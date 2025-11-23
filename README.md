# SmartDesk
### IT Support Ticketing System

SmartDesk is a comprehensive IT support ticketing solution designed to streamline helpdesk operations. It facilitates efficient issue tracking and resolution by connecting End Users with specialized Helpdesk Agents, all overseen by Super Administrators.

## Key Features

*   **Role-Based Access Control (RBAC):** Distinct dashboards and permissions for **Super Admins**, **Helpdesk Agents**, and **End Users**.
*   **Intelligent Ticket Routing:** Tickets are automatically assigned to available agents based on the ticket's category (e.g., Hardware, Software, Network).
*   **Ticket Lifecycle Management:** Full workflow support from creation to closure (Open &rarr; In Progress &rarr; Resolved &rarr; Closed).
*   **Priority & Categorization:** Users can tag tickets with priorities (Low, Medium, High) and specific categories to ensure critical issues are addressed first.
*   **Audit Trail:** Detailed history tracking for every ticket, recording status changes, assignments, and remarks.
*   **User Management:** Administrative tools to create users, manage roles, and toggle account status.
*   **Secure Authentication:** Includes forced password changes for new accounts and secure session management.

## Tech Stack

*   **Backend:** [Laravel 12](https://laravel.com) (PHP 8.2+)
*   **Frontend:** Blade Templates, [Tailwind CSS 4.0](https://tailwindcss.com)
*   **Database:** MySQL (Compatible with WAMP/XAMPP)
*   **Build Tools:** [Vite](https://vitejs.dev), [Composer](https://getcomposer.org), [NPM](https://www.npmjs.com)

## Installation Instructions (Windows / WAMP)

Follow these steps to set up the project on your local Windows machine using WAMP Server.

### Prerequisites
*   **WAMP Server** installed and running (Apache, MySQL, PHP).
*   **Git** installed.
*   **Composer** installed.
*   **Node.js & NPM** installed.

### Steps

1.  **Clone the Repository**
    Open your terminal (Command Prompt or PowerShell) and navigate to your `www` directory (usually `C:\wamp64\www`).
    ```bash
    git clone <repository-url>
    cd smartdesk
    ```

2.  **Install Backend Dependencies**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**
    ```bash
    npm install
    ```

4.  **Configure Environment**
    Copy the example environment file:
    ```bash
    copy .env.example .env
    ```

    Open the `.env` file in your text editor. Update the database settings to match your WAMP default configuration (**User: root, Password: empty**):
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=smartdesk
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Create Database & Run Migrations**
    Ensure your WAMP MySQL server is running. The following command will create the database (if it doesn't exist), create the tables, and seed the system with default users:
    ```bash
    php artisan migrate --seed
    ```

7.  **Build Assets**
    ```bash
    npm run build
    ```

## Usage

1.  **Start the Application**
    Since you are on WAMP, you can access the site via `http://localhost/smartdesk/public` OR you can run the artisan server:
    ```bash
    php artisan serve
    ```
    Access at: `http://localhost:8000`

2.  **Login Credentials**
    The system comes pre-loaded with the following accounts:

    | Role | Email | Password |
    |------|-------|----------|
    | **Super Admin** | `admin@smartdesk.com` | `admin123` |
    | **Helpdesk Agent** | `john.smith@smartdesk.com` | `agent123` |
    | **End User** | `alice.brown@company.com` | `user123` |

### Screenshots

*(Place screenshots of the Dashboard here)*

*(Place screenshots of the Ticket Creation form here)*

*(Place screenshots of the Agent Ticket Pool here)*

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
