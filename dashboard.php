<?php
require_once "../config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Not authorized");
}

$userid = $_SESSION['user_id'];

/* Total Contacts */
$total = $conn->query("SELECT COUNT(*) AS total FROM contacts")->fetch_assoc()['total'];

/* Contacts assigned to current user */
$stmt = $conn->prepare("SELECT COUNT(*) AS mine FROM contacts WHERE assigned_to = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$mine = $stmt->get_result()->fetch_assoc()['mine'];

/* 5 most recent contacts */
$recent = $conn->query("
    SELECT id, firstname, lastname, company, type, created_at
    FROM contacts
    ORDER BY created_at DESC
    LIMIT 5
");
?>

<div class="dashboard-wrapper">

    <h2 class="page-title">Dashboard</h2>

    <div class="stats-container">
        <div class="stat-card">
            <h4>Total Contacts</h4>
            <p class="stat-value"><?= $total ?></p>
        </div>

        <div class="stat-card">
            <h4>Assigned to Me</h4>
            <p class="stat-value"><?= $mine ?></p>
        </div>

        <div class="stat-card">
            <h4>Recently Added</h4>
            <p class="stat-value"><?= $recent->num_rows ?></p>
        </div>
    </div>

    <h3 class="section-title">Recently Added Contacts</h3>

    <table class="crm-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Type</th>
                <th>Created</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $recent->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                    <td><?= $row['company'] ?></td>
                    <td><?= $row['type'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <button class="view-btn" data-id="<?= $row['id'] ?>">View</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>
