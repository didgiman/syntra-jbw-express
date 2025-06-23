# EventR

## App Description
 
EventR is an event management system to address the need for a user-friendly, flexible platform that simplifies organizing both small and large events. Many organizers rely on separate tools for registration, communication, planning, and payments—our system brings these features together in one centralized solution.
 
Designed for a wide range of users—from independent instructors to major festival organizers—it’s scalable, intuitive, and easy to use, even without technical expertise. This project allowed us to combine our skills in database management, web development, UX design, and planning into a practical application that helps modernize and streamline event organization.
 
# Event Management - Local Installation Guide
 
Follow these steps to set up the project locally:
 
## Prerequisites
 
- [Node.js](https://nodejs.org/) (v14 or higher)
- [npm](https://www.npmjs.com/) or [yarn](https://yarnpkg.com/)
- [Composer](https://getcomposer.org/) (for PHP dependencies)
- [Git](https://git-scm.com/)
 
## Installation
 
1. **Clone the repository:**
    ```bash
    git clone https://github.com/didgiman/syntra-jbw-express.git
    cd syntra-jbw-express
    ```
 
2. **Install Node.js dependencies:**
    ```bash
    npm install
    ```
    _or, if using yarn:_
    ```bash
    yarn install
    ```
 
3. **Install PHP dependencies:**
    ```bash
    composer install
    ```
 
4. **Configure environment variables:**
    - Copy `.env.example` to `.env` and update values as needed.
    - Generate an application key:
      ```bash
      php artisan key:generate
      ```
 
5. **Set up the database:**
    - Run migrations to create the database tables:
      ```bash
      php artisan migrate
      ```
    - (Optional) Seed the database with test data:
      ```bash
      php artisan db:seed
      ```
 
6. **Run the local server:**
    ```bash
    composer run dev
    ```
 
7. **Access the app:**
    - Open [http://localhost:8000](http://localhost:8000) in your browser.
 
## Additional Notes
 
- For issues, please open a ticket in the Issues section.
 
## Filament Access
 
To work with the Filament admin panel, you must create an email account ending with `@eventr.be`.<br>
After registration, verify this email address to gain proper access to the Filament layer of the application.<br>
To access the Filament admin panel, visit: [http://localhost:8000/admin](http://localhost:8000/admin)
