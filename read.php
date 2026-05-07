<?php
include 'db.php';

$all_fields = [
    'stud_no'   => 'Student No',
    'lastname'  => 'Last Name',
    'firstname' => 'First Name',
    'sex'       => 'Sex',
    'bdate'     => 'Birth Date',
    'age'       => 'Age',
    'religion'  => 'Religion',
    'talent'    => 'Talent'
];

$selected_fields = isset($_GET['fields']) && is_array($_GET['fields'])
    ? $_GET['fields']
    : array_keys($all_fields);

// Read JSON data
$data = readData();

// Filter
$filter_lname = isset($_GET['filter_lname'])
    ? strtolower(trim($_GET['filter_lname']))
    : "";

if (!empty($filter_lname)) {
    $data = array_filter($data, function($row) use ($filter_lname) {
        return strpos(strtolower($row['lastname']), $filter_lname) !== false;
    });
}

// Sorting
$sort_field = isset($_GET['sort_field']) ? $_GET['sort_field'] : "stud_no";
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : "ASC";

$valid_sort_fields = array_keys($all_fields);

if (!in_array($sort_field, $valid_sort_fields)) {
    $sort_field = "stud_no";
}

usort($data, function($a, $b) use ($sort_field, $sort_order) {

    $valueA = $a[$sort_field];
    $valueB = $b[$sort_field];

    if ($valueA == $valueB) {
        return 0;
    }

    if ($sort_order == "ASC") {
        return ($valueA < $valueB) ? -1 : 1;
    } else {
        return ($valueA > $valueB) ? -1 : 1;
    }
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Classmates</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>View Classmates</h2>

    <div class="actions">
        <a href="index.php">Back to Home</a> |
        <a href="create.php">Add New Record</a>
    </div>

    <form method="GET" class="filter-bar">

        <div>
            <label>Filter by Last Name:</label>

            <input
                type="text"
                name="filter_lname"
                value="<?php echo htmlspecialchars($filter_lname); ?>"
            >
        </div>

        <div>
            <label>Sort By:</label>

            <select name="sort_field">

                <?php
                foreach ($all_fields as $key => $label) {

                    $selected = ($sort_field == $key) ? "selected" : "";

                    echo "<option value='$key' $selected>$label</option>";
                }
                ?>

            </select>
        </div>

        <div>
            <label>Order:</label>

            <select name="sort_order">

                <option value="ASC" <?php if($sort_order=="ASC") echo "selected"; ?>>
                    ASC
                </option>

                <option value="DESC" <?php if($sort_order=="DESC") echo "selected"; ?>>
                    DESC
                </option>

            </select>
        </div>

        <div class="checkbox-section">

            <label class="checkbox-section-label">
                Select Fields:
            </label>

            <div class="checkbox-group">

                <?php
                foreach ($all_fields as $field_key => $field_label) {

                    $checked = in_array($field_key, $selected_fields)
                        ? "checked"
                        : "";

                    echo "
                    <label class='checkbox-label'>
                        $field_label
                        <input
                            type='checkbox'
                            name='fields[]'
                            value='$field_key'
                            $checked
                        >
                    </label>";
                }
                ?>

            </div>
        </div>

        <button type="submit" class="apply-btn">
            Apply
        </button>

    </form>

    <div class="table-responsive">

        <table>

            <tr>

                <?php
                foreach ($selected_fields as $field) {

                    if (isset($all_fields[$field])) {

                        echo "<th>".$all_fields[$field]."</th>";
                    }
                }
                ?>

                <th>Actions</th>

            </tr>

            <?php

            if (!empty($data)) {

                foreach ($data as $row) {

                    echo "<tr>";

                    foreach ($selected_fields as $field) {

                        if (isset($row[$field])) {

                            echo "<td>".htmlspecialchars($row[$field])."</td>";
                        }
                    }

                    echo "
                    <td>
                        <a href='update.php?stud_no=".$row['stud_no']."'>
                            Edit
                        </a>
                        |
                        <a
                            href='delete.php?stud_no=".$row['stud_no']."'
                            onclick=\"return confirm('Delete this record?')\"
                        >
                            Delete
                        </a>
                    </td>";

                    echo "</tr>";
                }

            } else {

                $colspan = count($selected_fields) + 1;

                echo "
                <tr>
                    <td colspan='$colspan' style='text-align:center'>
                        No records found
                    </td>
                </tr>";
            }

            ?>

        </table>

    </div>

</div>

</body>
</html>