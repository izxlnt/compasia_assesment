## 📦 Setup Instructions

1️⃣ Clone the Repository

  - git clone https://github.com/your-repo/product-management.git
  - cd product-management

2️⃣ Install Backend Dependencies

  - composer install

3️⃣ Configure Environment Variables

  - Copy the .env.example file and update the database credentials:
  - cp .env.example .env
  - Update .env file:

      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=your_database_name
      DB_USERNAME=your_db_user
      DB_PASSWORD=your_db_password
      
      QUEUE_CONNECTION=database

4️⃣ Run Database Migrations

  - php artisan migrate

5️⃣ Seed Dummy Data (Optional)

  - php artisan db:seed

6️⃣ Install Frontend Dependencies

  - npm install

7️⃣ Build Frontend Assets

  - npm run dev

8️⃣ Start Laravel Server

  - php artisan serve
  - The backend API will be available at http://127.0.0.1:8000.

9️⃣ Start Vite Development Server (Vue)

  - npm run dev
  - Vue frontend will be available at http://localhost:5173.


## 🔄 Queue Setup & Processing

1️⃣ Configure Queue

  - Ensure your .env file has:
  - QUEUE_CONNECTION=database

2️⃣ Start the Queue Worker

  - Run the following command to start processing jobs:
  - php artisan queue:work

3️⃣ Monitor Queued Jobs

  - You can check pending jobs with:
  - php artisan queue:failed
  - To retry failed jobs:
  - php artisan queue:retry all
  - To process jobs in the background, use Supervisor (Linux) or a similar service.

