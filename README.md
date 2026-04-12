# Freshly Banners - Prueba Técnica (PHP/Symfony)

## Resumen
Este proyecto reemplaza la dependencia del módulo de banners en PrestaShop por una implementación en Symfony.

Incluye:
- CRUD de banners
- Renderizado en Home de banners visibles por idioma
- Datos iniciales (fixtures) de idiomas y colores
- Entorno local con Docker

## Alcance funcional
Cada banner se define por:
- `active`
- `internal_name`
- `start_date`
- `end_date`
- `background_color`
- `content` (por idioma)
- `active_lang` (por idioma)

Reglas de visualización en Home:
- Solo se muestran banners activos
- La fecha actual debe estar entre `start_date` y `end_date`
- Se muestra el contenido de la traducción del idioma seleccionado
- La traducción debe estar activa (`active_lang = true`)

## Decisiones de arquitectura
### Backend
- Controladores en `src/Controller`
- Entidades y mapeo ORM en `src/Entity`
- Consultas de dominio en `src/Repository`
- Servicio de caso de uso en `src/Service/GetBannersForLocal.php`

### Frontend (server-rendered)
- Plantillas Twig en `templates/`
- Assets estáticos en `public/` (CSS y JS)
- Gestión dinámica de traducciones con jQuery en `public/js/banner-form-collection.js`

### Motivo de esta estructura
- Separación clara de responsabilidades
- Mayor mantenibilidad y legibilidad
- Fácil evolución futura sin acoplar reglas de negocio a la vista

## Integración en backoffice de PrestaShop (propuesta de diseño)
No se implementa integración real en esta prueba, pero esta sería la propuesta.

### Propuesta breve
No tengo experiencia profunda con módulos internos de PrestaShop, así que no quiero inventar una integración cerrada.

Mi propuesta sería mantener la lógica de banners en Symfony y exponerla desde el backoffice de PrestaShop mediante una entrada tipo "Banners", consumiendo esa funcionalidad por servicio o API interna.

Esto reduce acoplamiento, centraliza la lógica de negocio y deja la solución más fácil de mantener y evolucionar.

## Estructura del proyecto
- `src/Controller/BannerController.php`: CRUD de banners
- `src/Controller/HomeController.php`: renderizado Home
- `src/Repository/BannerRepository.php`: query de visibilidad por idioma/fecha
- `src/Service/GetBannersForLocal.php`: servicio de aplicación para Home
- `templates/banner/*`: vistas de gestión
- `templates/home/index.html.twig`: Home pública
- `public/js/banner-form-collection.js`: add/remove de traducciones
- `src/DataFixtures/AppFixtures.php`: datos iniciales

## Ejecución local (Docker)
1. Crear el archivo de entorno a partir del ejemplo:
```bash
cp .env.sample .env
```

2. Construir y levantar:
```bash
docker compose up --build -d
```

3. Acceder:
- Home: `http://localhost:8000/`
- CRUD banners: `http://localhost:8000/banner`

> Si ya tenías el entorno levantado y quieres empezar desde cero, puedes ejecutar antes `docker compose down -v` para borrar contenedores y volúmenes.

## Notas
- Los fixtures se cargan al iniciar el contenedor con `--append`.
- El entorno incluye configuración de Xdebug para depuración local.

## Pregunta final del case study
### ¿Cuál considero que es la principal responsabilidad del Full Stack Developer (PHP/Symfony)?
Traducir necesidades de negocio en funcionalidades completas y mantenibles, garantizando coherencia entre backend, frontend y datos.

### ¿Qué valor diferencial aporto yo?
Aporto foco en calidad de código, diseño simple y mantenible, y capacidad de iteración rápida con decisiones técnicas transparentes y justificadas.
