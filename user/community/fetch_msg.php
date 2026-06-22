<?php
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
session_start();
$username = $_SESSION['username'] ?? '';

// Define the highlightMentions function
function highlightMentions($text) {
    $pattern = '/@([a-zA-Z0-9_-]+(?:\s[a-zA-Z]+)*)(?=\s|\()/';
    $replacement = '<span style="color: #0d6efd;">@$1</span>';
    return preg_replace($pattern, $replacement, $text);
}

$query = "SELECT * FROM tbl_community_msgs";
$result = $connection->query($query);

while ($row = $result->fetch_assoc()) {
    $oid = $row['userid'];
    $queryUser = "SELECT * FROM tbl_users WHERE id = ?";
    $stmt = $connection->prepare($queryUser);
    $stmt->bind_param("i", $oid);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();
    $stmt->close();

    $isCurrentUser = ($_SESSION['id'] == $row['userid']);
?>
    <div class="col-12">
        <div class="<?= $isCurrentUser ? 'my-message' : 'card' ?>">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="<?= !empty($user['image']) ? '/miniproject/user/login/loginimg/' . htmlspecialchars($user['username']) . '.' . pathinfo($user['image'], PATHINFO_EXTENSION) : '/miniproject/user/login/loginimg/default-profile-pic.png' ?>" alt="Profile Picture" class="rounded-circle" width="40" height="40">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <p class="fw-medium mb-0" <?= !$isCurrentUser ? "onclick=\"window.location.href ='/miniproject/user/viewprofile/viewprofile.php?request-profile={$oid}';\"" : "" ?> style="cursor:pointer;"><?= htmlspecialchars($user['name']); ?></p>
                            <?php if ($isCurrentUser) { ?>
                                <span class="badge bg-success bg-opacity-25 text-success small">You</span>
                                <div class="dropdown">
                                    <span class="moreopt" data-bs-toggle="dropdown">⋮</span>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-danger delete-message" 
                                               href="#" 
                                               data-msgid="<?php echo $row['msgid']; ?>">Delete</a></li>
                                    </ul>
                                </div>
                            <?php } else { ?>
                                <div class="dropdown">
                                    <span class="moreopt" data-bs-toggle="dropdown">⋮</span>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item dropdown-toggle text-danger report-message" 
                                               href="#" 
                                               data-msgid="<?php echo $row['msgid']; ?>">Report</a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item report-reason" href="#" data-msgid="<?php echo $row['msgid']; ?>" data-reason="spam">Spam</a></li>
                                                <li><a class="dropdown-item report-reason" href="#" data-msgid="<?php echo $row['msgid']; ?>" data-reason="hate-speech">Hate Speech</a></li>
                                                <li><a class="dropdown-item report-reason" href="#" data-msgid="<?php echo $row['msgid']; ?>" data-reason="harassment">Harassment</a></li>
                                                <li><a class="dropdown-item report-reason" href="#" data-msgid="<?php echo $row['msgid']; ?>" data-reason="inappropriate Content">Inappropriate Content</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                        <p class="text-muted small mb-0"><?= date("F j, Y, g:i a", strtotime($row['time'])) ?></p>
                    </div>
                </div>
                <p class="mb-3"><?= highlightMentions(htmlspecialchars($row['message'])); ?></p>
                <?php if (!empty($row['image'])) { ?>
                    <div class="mb-3">
                        <img src="data:image/jpeg;base64,<?= base64_encode($row['image']); ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
}
$connection->close();
?>