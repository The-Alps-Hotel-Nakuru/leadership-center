# Force HRMS Export Command

## Overview

This automated export system generates Excel workbooks in a format compatible with Force HRMS import module. It exports all company data including employees, departments, designations, employment types, leave information, and financial records.

## Command Usage

### Basic Usage (Per-Company Deployment)

For a per-company deployment, simply run:

```bash
php artisan company:export-force-hrms
```

This will automatically:
- Use the company in the database
- Generate an export file named `export_company_{id}_{timestamp}.xlsx`
- Save it to `storage/exports/`

### Specify Custom Output Directory

```bash
php artisan company:export-force-hrms --output-path=/path/to/custom/location
```

Example:
```bash
php artisan company:export-force-hrms --output-path=/var/exports
```

## Export Format

### Required Sheets (Always Included)

1. **Company**
   - Fields: `name`, `email`, `phone`, `address`
   - Contains company master information

2. **Departments**
   - Fields: `name`, `description`
   - All departments for the company

3. **Designations**
   - Fields: `title`, `department_name`, `description`
   - Job designations mapped to departments

4. **Employees**
   - Fields: `first_name`, `last_name`, `email`, `designation`, `phone_number`, `date_of_birth`, `gender`, `national_id`, `date_of_employment`
   - Employee master data with email as primary identifier

### Optional Sheets (Included if Data Exists)

5. **EmploymentTypes**
   - Fields: `name`, `description`
   - Employment type classifications (Full-time, Casual, etc.)

6. **LeaveTypes**
   - Fields: `name`, `allowed_days`, `description`
   - Types of leave available (Annual, Sick, etc.)

7. **Leaves**
   - Fields: `employee_email`, `leave_type`, `start_date`, `end_date`, `days`
   - Leave records for employees

8. **Contracts**
   - Fields: `employee_email`, `contract_type`, `start_date`, `end_date`, `terms`
   - Employee contract information

9. **Fines**
   - Fields: `employee_email`, `date`, `amount`, `reason`
   - Disciplinary fines records

10. **Bonuses**
    - Fields: `employee_email`, `date`, `amount`, `reason`
    - Bonus records for employees

11. **Advances**
    - Fields: `employee_email`, `date`, `amount`, `reason`
    - Salary advance records

12. **WelfareContributions**
    - Fields: `employee_email`, `date`, `amount`, `contribution_type`
    - Employee welfare fund contributions

13. **Attendances**
    - Fields: `employee_email`, `date`, `check_in`, `check_out`
    - Daily attendance records with times

14. **ExtraWorks**
    - Fields: `employee_email`, `date`, `hours`, `description`
    - Overtime and extra work records

## Data Formats

All data is formatted for Force HRMS compatibility:

- **Dates**: YYYY-MM-DD format (e.g., 2024-01-15)
- **Times**: HH:MM:SS format (e.g., 09:30:00)
- **Email**: Primary identifier for employee linkage across sheets
- **Currency**: Amounts in KES (Kenyan Shillings)

## File Output

Generated files are saved with the following naming convention:

```
export_company_{company_id}_{timestamp}.xlsx
```

Example: `export_company_1_20240115093045.xlsx`

**Default Location**: `storage/exports/`

The export process:
1. Creates the output directory if it doesn't exist
2. Generates the Excel file with all relevant data
3. Reports file location and size on completion

## Error Handling

The command includes comprehensive error handling:

- Validates company exists in database
- Handles missing relationships gracefully (empty strings for null values)
- Logs errors to application logs
- Returns appropriate exit codes (0 for success, 1 for failure)

## Integration Steps

1. **Export Data**
   ```bash
   php artisan company:export-force-hrms
   ```

2. **Locate Export File**
   - Check `storage/exports/` directory
   - Latest file will have the current timestamp

3. **Upload to Force HRMS**
   - Log in to Force HRMS
   - Navigate to Import module
   - Upload the Excel file
   - Verify all sheets are recognized
   - Proceed with import validation

## Technical Details

### Database Queries

- All queries filter by company_id to ensure correct company data is exported
- Relationships are eager-loaded to optimize performance
- Optional sheets only include when data exists

### Email as Primary Identifier

Employees are identified by email across all sheets. This ensures:
- Correct linkage of employment history
- Proper attribution of leaves, fines, bonuses, etc.
- Accurate payroll and attendance records

### Key Relationships

```
Company
├── Departments
│   ├── Designations
│   │   └── Employees
│   │       ├── Contracts
│   │       ├── Leaves
│   │       ├── Attendances
│   │       ├── Fines
│   │       ├── Bonuses
│   │       ├── Advances
│   │       ├── WelfareContributions
│   │       └── ExtraWorks
│   └── EmploymentTypes
└── LeaveTypes
```

## Troubleshooting

### "No company found in database"
- Ensure at least one company record exists
- Check database connection in `.env`

### Missing optional sheets
- This is normal - optional sheets only appear if data exists
- Verify employment data exists for the company in Force HRM

### File not created
- Check storage directory permissions
- Ensure `storage/` directory is writable
- Check application logs in `storage/logs/`

### Email fields are empty
- Verify employees have associated User records
- Check User table for email values

## Command Examples

```bash
# Simple export (uses the company in database)
php artisan company:export-force-hrms

# Export with progress output
php artisan company:export-force-hrms -v

# Export to custom location
php artisan company:export-force-hrms --output-path=/var/exports

# Suppress all output (for cron jobs)
php artisan company:export-force-hrms --quiet
```

## Scheduling Exports

To schedule automatic exports, add to your `app/Console/Kernel.php`:

```php
$schedule->command('company:export-force-hrms')
    ->daily()
    ->at('02:00');
```

This will run the export daily at 2:00 AM and save to storage.

## Support

For issues or questions:
1. Check the error message in console output
2. Review application logs in `storage/logs/laravel.log`
3. Verify database connectivity and data integrity
4. Ensure storage directory has write permissions
