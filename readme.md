# Laravel Reflection
This is a Laravel practice project as part of my training with *Netmatters Ltd*.

## Building
0. Ensure PHP, Composer, Node.js, and npm are installed. Tested with PHP 7.4.16, Composer 2.0.11, npm 6.14.11, Node.js 14.15.5.

1. Rename `.env.example` to `.env`.
    * If desired the environment variables can be changed to use a remote database. The settings in `.env.example` will use a local SQLite database file.

2. Install dependencies, set up a symlink for storage, migrate and seed database, all by running:
    ```
    npm run build
    ```

3. Host locally
    ```
    npm start
    ```

4. Access at (by default) http://localhost:8000/

## Example user accounts
* `admin@example.com` | `password` - Full rights.
* `manager@example.com` | `password` - Full rights on employees. Can view companies.
* `accountant@example.com` | `password`- Can only view data.

## Features
* Company and employee tables, with a foreign key constraint on the employee's assigned company.
* Seeders to generate sample data.
* Create, read, update, and delete companies and employees.
* Access is controlled by user account rights, which are also reflected by disabling parts of the UI.
* Validation on entered data for companies and employees. Including valdiation of image files for use as a logo.
* Uploaded logo images are stored and publicly accessible. Uploaded images no longer in use are deleted.
* Employees can be assigned to a company, using a select form element generated from the companies in the database.
* Ability to list all employees that belong to a company.
* When creating a new user from that list of employees at a company, the company selection on the form is pre-filled.

## Tests
To run automated tests:
```
npm test
```
