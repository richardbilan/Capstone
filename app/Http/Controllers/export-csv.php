<?php

// Demographic data by Sitio/Purok
$demographicData = [
    ['Sitio/Purok', 'No. of Family', 'No. of Person (L)', 'No. of Person (B)', 'Infant 0-11 mos (L)', 'Infant 0-11 mos (B)', 'Children 17 & below (L)', 'Children 17 & below (B)', 'Adult 18-59 y/o (L)', 'Adult 18-59 y/o (B)', 'Elderly 60 & above (L)', 'Elderly 60 & above (B)', 'PWD', 'With sickness', 'Pregnant Women'],
    ['1', '123', '224', '249', '3', '2', '57', '67', '143', '151', '-', '-', '-', '-', '-'],
    ['2', '148', '352', '341', '2', '12', '92', '95', '214', '199', '-', '-', '-', '-', '-'],
    ['3', '149', '391', '309', '3', '2', '82', '83', '283', '187', '-', '-', '-', '-', '-'],
    ['4', '178', '311', '334', '2', '2', '79', '95', '198', '195', '-', '-', '-', '-', '-'],
    ['5', '220', '483', '456', '2', '6', '125', '123', '314', '268', '-', '-', '-', '-', '-'],
    ['Relocation', '194', '188', '187', '2', '2', '73', '70', '97', '97', '-', '-', '-', '-', '-'],
    ['Total', '1012', '1949', '1876', '14', '26', '508', '533', '1249', '1097', '-', '-', '-', '-', '-'],
];

// PWD Details data
$pwdData = [
    ['', '', '', '', '', '', '', '', '', '', ''],
    ['PWD Details', '', '', '', '', '', '', '', '', '', ''],
    ['Uri ng Kapansanan', '0-11 mos', '1-2', '3-5', '6-12', '13-17', '18->', 'B', 'L', 'Bilang', ''],
    ['Pandinig', '0', '1', '2', '3', '2', '12', '11', '9', '20', ''],
    ['Pananalita', '0', '0', '1', '2', '1', '8', '7', '5', '12', ''],
    ['Paningin', '0', '0', '0', '1', '1', '15', '9', '8', '17', ''],
    ['Pagiisip', '0', '1', '3', '4', '3', '10', '12', '9', '21', ''],
    ['Autism', '0', '0', '1', '2', '1', '2', '3', '3', '6', ''],
    ['Physical Skills', '0', '0', '2', '3', '2', '18', '14', '11', '25', ''],
    ['Others', '0', '1', '2', '5', '4', '25', '21', '16', '37', ''],
    ['Total', '0', '3', '11', '20', '14', '90', '89', '49', '138', ''],
];

// Household data
$householdData = [
    ['', '', '', '', '', '', '', '', '', '', ''],
    ['Household Data', '', '', '', '', '', '', '', '', '', ''],
    ['Uri ng Pamamahay', 'Bilang', '', '', '', '', '', '', '', '', ''],
    ['Concrete', '343', '', '', '', '', '', '', '', '', ''],
    ['Semi-Concrete', '276', '', '', '', '', '', '', '', '', ''],
    ['Light-weight', '134', '', '', '', '', '', '', '', '', ''],
    ['Salvaged house', '100', '', '', '', '', '', '', '', '', ''],
    ['Total', '853', '', '', '', '', '', '', '', '', ''],
];

// Summary statistics
$summaryData = [
    ['Summary Statistics', '', '', '', '', '', '', '', '', '', ''],
    ['Total Population', '3,825', '', '', '', '', '', '', '', '', ''],
    ['No. of Households', '853', '', '', '', '', '', '', '', '', ''],
    ['No. of Families', '1,126', '', '', '', '', '', '', '', '', ''],
    ['PWD Total', '138 (89 F, 49 M)', '', '', '', '', '', '', '', '', ''],
    ['', '', '', '', '', '', '', '', '', '', ''],
];

// Combine all data
$allData = array_merge($summaryData, $demographicData, $pwdData, $householdData);

// Generate CSV content
$csvContent = '';
foreach ($allData as $row) {
    $csvContent .= implode(',', array_map(function($field) {
        // Escape fields that contain commas, quotes, or newlines
        if (strpos($field, ',') !== false || strpos($field, '"') !== false || strpos($field, "\n") !== false) {
            return '"' . str_replace('"', '""', $field) . '"';
        }
        return $field;
    }, $row)) . "\n";
}

// Set headers for CSV download
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="ilawod_demographic_data_' . date('Y-m-d') . '.csv"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Output CSV content
echo $csvContent;
exit;