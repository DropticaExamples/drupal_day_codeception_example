# Drupal codeception demo

The purpose of this project demonstrate test capabilities of Codecetion
in Drupal CMS 

## Run local env with Docksal

### Prerequisites

* [Docksal](https://docksal.io/)

### Installing

1. Clone the git repository
   ```sh
   git clone git@github.com:DropticaExamples/drupal_day_codeception_example.git
   ```

2. Enter the newly created project directory
   ```sh
   cd drupal_day_codeception_example
   ```

3. Start docksal environment
   ```sh
   fin start
   ```

4. Install composer dependencies

   ```sh
   fin composer install
   ```

5. Install Drupal

   ```sh
   fin drush si --db-url=mysql://root:root@db/default
   ```
## Run tests

   ```sh
   fin test
   ```
