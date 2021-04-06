# Laravel Reflection
This is a Laravel practice project as part of my training with *Netmatters Ltd*.

## Building
1. Rename `.env.example` to `.env`. If desired the environment variables can be changed to use a remote database. The settings in `.env.example` will use a local SQLite database file.

2. Install dependencies, set up a symlink for storage, migrate and seed database, all by running:
```
npm run build
```

3. Host locally
```
npm start
```

4. Access at (by default) http://localhost:8000/

## Available user accounts
* `admin@example.com` `password` - Full rights.
* `manager@example.com` `password` - Full rights on employees. Can view companies.
* `accountant@example.com` `password`- Only view.

## Features
* Company and employee tables, with a foreign key constraint on the employee's assigned company.
* Seeders to generate sample data.
* Create, read, update, and delete for companies and employees.
* Validation on entered data for companies and employees. Including valdiation of image files for use as a logo.
* Employees can be assigned to a company, using a select form element generated from the companies in the database.
* All employees that belong to a company can be listed.
* When creating a new user from that list of employees at a company, the company selection on the form is pre-filled.
* User accounts with varied permissions for what they can edit.

## Tests
To run automated tests:
```
npm test
```
