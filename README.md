# Lawyer AI Assistant

Lawyer AI Assistant is a Laravel-based web application that streamlines the creation of legal contract drafts—specifically for vehicle sale transactions—by guiding users through a multi-step form. The system collects all necessary data (vehicle, seller, buyer, and contract details) and generates a draft contract using a pre-made HTML template. The draft can then be reviewed and updated through an integrated AI feedback process via n8n.

## Project Goals

- **Automate Legal Document Creation:** Simplify the process of drafting contracts by automating the generation of legal documents based on user input.
- **Improve Efficiency:** Reduce the time required to prepare legal contracts for vehicle sales by using a step-by-step form and templating system.
- **Integrate AI Feedback:** Incorporate AI through n8n to review and suggest modifications to the contract draft, ensuring accuracy and legal compliance.
- **User-Friendly Interface:** Provide an intuitive and responsive interface for both lawyers and clients to input data and review contract drafts.

## Features

- **Multi-Step Data Collection:**  
  - **Step 1:** Vehicle details (brand, model, color, chassis, engine, plate, year, price, etc.)  
  - **Step 2:** Seller information (name, ID, address, city, country, etc.)  
  - **Step 3:** Buyer information (name, ID, address, city, country, etc.)  
  - **Step 4:** Contract details (notary selection, contract date, location, custom fields, etc.)

- **Contract Draft Generation:**  
  The application uses a predefined HTML template to generate a draft contract with placeholders replaced by session data.

- **AI Feedback Integration:**  
  After generating the draft, the lawyer can provide feedback. This feedback is sent to an AI processing endpoint (n8n) to update the contract automatically.

- **Responsive Design:**  
  The application uses a modern, mobile-friendly design ensuring usability across devices.

## Technologies Used

- **Laravel:** PHP framework used for building the backend and managing multi-step form submissions.
- **Blade Templating Engine:** For rendering dynamic HTML content.
- **n8n:** Workflow automation tool integrated for AI-driven feedback.
- **Git & GitHub:** Version control for collaborative development.

## Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/juniorspy/Lawyer-ai-asistant.git
Navigate to the Project Directory:
bash
Copiar
cd Lawyer-ai-asistant
Install Dependencies:
bash
Copiar
composer install
npm install
npm run dev
Configure Environment Variables:
Copy .env.example to .env and set up your database and other environment variables.
bash
Copiar
cp .env.example .env
Generate Application Key:
bash
Copiar
php artisan key:generate
Run Migrations (if applicable):
bash
Copiar
php artisan migrate
Run the Application:
bash
Copiar
php artisan serve
Usage
Start at the Home Page:
Access the application via your browser at http://localhost:8000.

Follow the Multi-Step Process:

Select Contract Type: Begin by selecting the vehicle sale contract.
Fill Out the Forms: Input the required details for the vehicle, seller, buyer, and contract.
Generate and Review the Draft: The draft contract is generated from the template with your inputs.
Submit Feedback: Optionally, send feedback for AI review to update the contract.
Contributing
Contributions are welcome!

Fork the repository.
Create your feature branch (git checkout -b feature/my-feature).
Commit your changes (git commit -am 'Add some feature').
Push to the branch (git push origin feature/my-feature).
Create a new Pull Request.
License
This project is licensed under the MIT License.

Contact
For any questions, suggestions, or issues, please contact Hector Espino.