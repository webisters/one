# Webisters One

Webisters One Project This project is intended as an application-level codebase that can be configured and extended for local or deployed environments.

## What Is Included
- A project-oriented foundation for building and organizing application features.
- Configuration and dependency wiring that supports repeatable local setup.
- Conventions for adding routes, services, and domain-specific functionality.

## Setup
```bash
composer global require webisters/webisters
php webisters new-one one
cd one
```

## Run Locally
```bash
php webisters start
```
If the custom runtime command is unavailable, use: `php -S localhost:8000 -t public`.

## Testing
```bash
vendor/bin/phpunit
```

## Project Structure
- `public/`: Public web root and entrypoint files.
- `tests/`: Automated tests and supporting fixtures.

## Support
- Issues: https://github.com/webisters/one/issues
- Source: https://github.com/webisters/one
- Documentation: https://webisters.com
- Forum: https://github.com/webisters/forum
- Email: support@webisters.com

## License
MIT
