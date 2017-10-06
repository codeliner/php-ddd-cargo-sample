# Annotated Project Structure

```
+-- CargoBackend                   # Cargo Booking Context
|  +-- src                             # Production source code
|  |  +-- Application                      # Application layer
|  |  |  +-- Booking                           # Booking Application Service
|  |  |  +-- Exception                         # Application related exceptions
|  |  +-- Http
|  |  |  |  +-- Action                         # REST API Endpoints (as PSR-7)
|  |  +-- Container                            # Namespace for all service factories
|  |  |  +-- ...                               # Same sub structure as in src
|  |  +-- Infrastructure                   # Infrastructure layer
|  |  |  +-- Persistence                       # Persistence module
|  |  |  |  +-- Doctrine                       # Doctrine integration
|  |  |  |  |  +-- ORM                         # Doctrine xml configs
|  |  |  |  |  +-- Type                        # Custom Doctrine types
|  |  |  |  |  +-- DoctrineCargoRepository.php # CargoRepository implementation
|  |  |  |  +-- Transaction                    # Transaction handling
|  |  |  +-- Routing                           # Routing Context Translation Adapter
|  |  +-- Model                            # Domain layer
|  |  |  +-- Cargo                             # Cargo Aggregate
|  |  |  +-- Routing                           # Routing Service contract
|  +-- tests                           # Cargo Unit Tests
+-- CargoUI                        # User Interface module 
|  +-- src                             # Server-side source code
|  |  +-- Container                        # Service factories
|  |  +-- Main.php                         # PSR-7 Middleware to serve home page
|  |  +-- RiotCompiler.php                 # riot.js tags compiler written in PHP
|  +-- view                            # riot.js tags with combined HTML5 and JS
+-- GraphTraversalBackend          # Simulated Routing Context (Supporting Sub-Domain)
+-- bin                            # CLI scripts
|  +-- migrations.php                  # Doctrine migrations CLI tool
|  +-- ...                             # All vendor CLI tools will be installed here too
+-- config                         # System configuration
|  +-- autoload                        # All configs in this dir are loaded automatically
|  |  +-- local.php.dist               # Rename to local.php and align database config
|  |  +-- ...                          # All other configs are ready to use
|  +-- config.php                      # Config autoload script
|  +-- container.php                   # Container initialization script
|  +-- behat.yml.dist                  # Rename to behat.yml and align base_url to run behat tests
+-- data                           # Mainly used for caching, make sure webserver has write access!
+-- docs                           # Documentation
+-- features                       # Behat Features
+-- migrations                     # Database migration scripts used by Doctrine Migrations
+-- public                         # Public root of the project
|  +-- index.php                       # PHP boostrap file for all non static routes
|  +-- ...                             # All static files like css, global JS, images, etc.
|  +-- vendor                      # Composer installation root for all vendor libs
+-- .travis.yml                    # Configuration for travis-ci
+-- composer.json                  # Composer config
+-- composer.lock                  # Composer lock of all installed vendor libs
+-- composer.phar                  # Executable Composer Phar Archiv
+-- LICENCE.txt                    # Licence file
+-- migrations.xml                 # Doctrine Migrations config
+-- README.md                      # Project readme
+-- selenium-server-standalone-2.46.0.jar  # Selenium Server executable run it with java -jar ... 
```
