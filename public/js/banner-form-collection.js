(function ($) {
    const SELECTORS = {
        container: '#banner-contents',
        addButton: '#add-content',
        item: '.banner-content-item',
        title: '.translation-title',
        removeButton: '.remove-content'
    };

    const BannerCollection = {
        init() {
            this.$container = $(SELECTORS.container);
            this.$addButton = $(SELECTORS.addButton);

            if (!this.$container.length || !this.$addButton.length) {
                return;
            }

            this.index = Number(this.$container.data('index')) || this.$container.children(SELECTORS.item).length;

            this.bindEvents();
            this.renumberItems();
        },

        bindEvents() {
            this.$addButton.on('click', () => this.addItem());

            this.$container.on('click', SELECTORS.removeButton, (event) => {
                this.removeItem($(event.currentTarget));
            });
        },

        addItem() {
            const prototype = this.$container.data('prototype');

            if (!prototype) {
                return;
            }

            const newForm = String(prototype).replace(/__name__/g, this.index);
            const $item = this.buildTranslationItem(newForm, this.index + 1);

            $item.hide();
            this.$container.append($item);
            $item.slideDown(120);

            this.index += 1;
            this.$container.data('index', this.index);
            this.renumberItems();
        },

        removeItem($button) {
            const $item = $button.closest(SELECTORS.item);

            $item.slideUp(120, () => {
                $item.remove();
                this.renumberItems();
            });
        },

        renumberItems() {
            this.$container.children(SELECTORS.item).each((position, element) => {
                $(element).find(SELECTORS.title).text('Translation #' + (position + 1));
            });
        },

        buildTranslationItem(formHtml, position) {
            const $item = $('<div class="banner-content-item border rounded-4 bg-light-subtle p-3 mb-3 shadow-sm"></div>');
            const header = [
                '<div class="d-flex justify-content-between align-items-center mb-2">',
                '<span class="translation-title fw-semibold">Translation #' + position + '</span>',
                '<button type="button" class="btn btn-outline-danger btn-sm remove-content">Remove</button>',
                '</div>'
            ].join('');

            $item.html(header + formHtml);

            return $item;
        }
    };

    $(function () {
        BannerCollection.init();
    });
})(jQuery);
