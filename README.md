# Ticket Analytics PRO

Mathematical revenue analysis tool built with **Symfony 6.4**.  
The application processes high-volume ticket sales data from **Excel streams** and applies **complex business logic** to calculate cooperation costs, monthly revenue, and fiscal year performance.

---

## Screenshots

![Ticket Financial 1](assets/images/screenshots/ticket_financial_1.png)  
*Excel import interface with dual-block layout support.*

![Ticket Financial 2](assets/images/screenshots/ticket_financial_2.png)  
*Main dashboard showing monthly revenue and cooperation costs.*


---

## Features

- **Excel Import**
    - Supports dual-block layouts (2023/2024) exactly as specified in the task.
    - Handles online and offline ticket counts per month.

- **Business Logic**
    - Calculates total revenue based on an average ticket price of 70 PLN.
    - Computes cooperation cost including:
        - Monthly subscription fee (8 000 PLN)
        - Commission: 2.5% of ticket value, with a minimum of 1.1 PLN per ticket

- **Quality**
    - Strictly typed PHP 8.1 code
    - Verified with **PHPStan** for static analysis
    - Tested with **PHPUnit**

---

## ⚙️ Quick Start
```bash
make setup
make quality
make tests
symfony server:start
```
