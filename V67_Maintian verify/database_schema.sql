-- Main table for Device Verify Information
CREATE TABLE `verify_main` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `part6` VARCHAR(255) NOT NULL,
  `device_name` VARCHAR(255) NOT NULL,
  `pcr_owner` VARCHAR(255),
  `otc_owner` VARCHAR(255),
  `rd_owner` VARCHAR(255),
  `corr_wafer` TEXT,
  `clean_pad_type` VARCHAR(255),
  `verify_sort` VARCHAR(255),
  `verify_method` VARCHAR(255),
  `rule_verify_pass` VARCHAR(255),
  `rule_contact_window` VARCHAR(255),
  `rule_dib_check` VARCHAR(255),
  `general_remark` TEXT,
  `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for the related "Verify Data" items with the new structure
-- (up to 5 per main entry)
CREATE TABLE `verify_details` (
  `detail_id` INT AUTO_INCREMENT PRIMARY KEY,
  `verify_id` INT NOT NULL,
  `type_name` VARCHAR(255),
  `test_program` VARCHAR(255),
  `test_od` VARCHAR(255),
  `prober_file` VARCHAR(255),
  `clean_od` VARCHAR(255),
  FOREIGN KEY (`verify_id`) REFERENCES `verify_main`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
