# Quick Start - Force HRMS Export

## One-Line Export

```bash
php artisan company:export-force-hrms
```

That's it! The export will:
- Use the company name from your `.env` file (COMPANY_NAME)
- Generate an Excel file with all data
- Save it to `storage/exports/export_company_[id]_[timestamp].xlsx`
- Show you the file location and size

## Find Your Export File

After running the command, your file is in:
```
storage/exports/
```

Look for the file starting with `export_company_` and the most recent timestamp.

## Upload to Force HRMS

1. Download the Excel file from `storage/exports/`
2. Log into Force HRMS admin panel
3. Go to: **Settings → Import**
4. Click **Upload Excel**
5. Select your exported file
6. Click **Import**
7. Verify the data

## What Gets Exported

✅ **Always Exported:**
- Company info (name, email, phone, address)
- All departments
- All job designations
- All employees

✅ **Auto-Included if Data Exists:**
- Employment types
- Leave types and records
- Employee contracts
- Attendances (with clock in/out times)
- Fines, Bonuses, Advances
- Welfare contributions
- Extra work/overtime

## Options

### Save to Custom Location
```bash
php artisan company:export-force-hrms --output-path=/var/exports
```

## Troubleshooting

| Problem | Solution |
|---------|----------|
| File not created | Check `storage/logs/laravel.log` for errors |
| "No company configured" error | Ensure `COMPANY_NAME` is set in `.env` file |
| Empty company data | Verify company record exists in database |
| Missing employee data | Verify employees have user accounts with emails |
| File permission error | Check `storage/` directory is writable |

## Data Formats Used

- **Dates**: 2024-01-15 (YYYY-MM-DD)
- **Times**: 09:30:00 (HH:MM:SS)
- **Email**: primary@company.com (employee identifier)
- **Currency**: 50000 (in KES, no symbol)

## Files Created

The implementation added these files:
- `app/Console/Commands/ExportCompanyForceHRMS.php` - Main command
- `app/Exports/ForceHRMS/` - All export sheet classes (15 files)

## Full Documentation

For detailed information, see:
- `FORCE_HRMS_EXPORT_README.md` - Complete user guide
- `FORCE_HRMS_EXPORT_IMPLEMENTATION.md` - Technical details

## Example Output

```
Starting export for company: Vapor Technologies (ID: 1)
✓ Export completed successfully!
File: /var/www/leadership-center/storage/exports/export_company_1_20240115093045.xlsx
Size: 2.45 MB
```

## That's All!

Your export is ready to import into Force HRMS. The system handles all the data mapping and formatting automatically.
