# Database Fundamentals Task - Laravel Implementation

##  Features

### Database Basics
- Master tables for Customers and Products
- Transaction tables for Orders and Payments
- Proper data types and constraints (NOT NULL, UNIQUE, etc.)

### Querying and Joins
- Customer-Order joins with relationship management
- Sales aggregation per customer
- Date range and status filtering
- Advanced aggregate functions (SUM, COUNT, AVG, MAX, MIN)

### Report Generation
- Daily sales reports with grouping
- Customer sales summaries
- Order status analytics
- Comprehensive sales dashboard

### Optimization
- Strategic database indexing
- Query performance analysis with EXPLAIN
- Database views for complex reporting
- Caching strategies

##  Requirements

- PHP 8.0+
- Composer
- MySQL 5.7+
- Laravel 10+


##  Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/aki961996/database_fundamentals_task.git
   cd database_fundamentals_task
   
#step by step -------->

    composer install
    
    cp .env.example .env
    
    php artisan key:generate
    
    php artisan migrate --seed
    
    php artisan serve
