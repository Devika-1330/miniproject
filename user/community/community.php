<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if ($_SESSION['username'] == '') {
  header("location: /miniproject/user/login/login.php");
  exit();
}

include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
$uid=$_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
$joincheck="select userid from tbl_community where userid ='$uid'";
$resultjoin=$connection->query($joincheck);
if ($resultjoin->num_rows > 0) {
  echo "<script>
      document.addEventListener('DOMContentLoaded', function() {
          document.getElementById('joincommunity').style.display = 'none';

      });
  </script>"; 
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ReRead Community</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body
      .post-content img { max-height: 400px; object-fit: fill; }
      .comment-thread { margin-left: 48px; }
      .question-mark {
        cursor: pointer;
        transition: color 0.3s ease;
      }
      .question-mark:hover {
        color: #0d6efd;
      }
      .my-message {
        background-color: rgba(245, 245, 245, 0.84);
        border: 2px solid var(--primary-color);
        padding: 1rem;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      }
      /* Add scrollbar to posts section */
      .posts-container {
        max-height: 100vh; /* Limits height to 70% of viewport height */
        overflow-y: auto; /* Vertical scrollbar when content overflows */
        padding-right: 10px; /* Space for scrollbar */
      }
      /* Ensure main layout supports scrolling */
      main {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }
      .container-xl {
        flex-grow: 1;
      }
      .file-input {
  position: absolute;
  left: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer;
}
.image-upload-label {
  cursor: pointer;
  width: 40px; /* Fixed width */
  height: 40px; /* Fixed height */
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.file-input {
  position: absolute;
  opacity: 0;
  width: 40px; /* Match label width */
  height: 40px; /* Match label height */
  cursor: pointer;
  left: 0;
  top: 0;
}

/* Ensure the button stays circular and consistent */
.btn.rounded-circle {
  width: 40px;
  height: 40px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Optional: Add hover effect */
.image-upload-label:hover {
  background-color: #e9ecef;
}
/* Scroll-to-bottom arrow */


  .moreopt {
    font-weight:bold;
    font-size:18px;
    margin-left:auto;
    cursor: pointer;
  }
  .join-community-container {
  position: fixed;
  top: 50%;
  left: 50%;
  width: 80%;
display:flex;
flex-direction:column;
  height: 80%;
  transform: translate(-50%, -50%);
  background: linear-gradient(135deg, #6a11cb, #2575fc);
  color: white;
  padding: 35px;
  border-radius: 12px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  text-align: center;
  justify-content:center;
  align-items:center;
  z-index: 0;
  animation: fadeIn 0.5s ease-in-out forwards;
}


@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
.join-community-container p {
  font-size: 16px;
  margin-bottom: 15px;
}

.join-community-container ul {
  list-style: none;
  padding: 0;
}

.join-community-container ul li {
  font-size: 18px;
  margin: 15px 0;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.join-community-container button {
  background:blue;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
  margin-top: 15px;
  transition: all 0.3s ease-in-out;
}

.join-community-container button:hover {
  background: white;
  color:black;
  transform: scale(1.05);
}

.sticker-container {
  background: #f8f9fa;
  padding: 5px;
  border-radius: 8px;
  border: 1px solid #dee2e6;
}

.sticker:hover {
  transform: scale(1.1);
  transition: transform 0.2s ease;
}

.emoji-toggle {
  transition: background-color 0.2s ease;
}

.emoji-toggle:hover {
  background-color: #e9ecef;
}

.emoji-toggle.active {
  background-color: #0d6efd;
  color: white;
}
.keysearch1 {
    position: absolute;
    bottom: 100%;
    left: 0;
    width: 300px;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    background: white;
    border-radius: 4px;
}

.keyitem1:hover {
    background-color: #f0f0f0;
}
#kickcommunity{
  display:none;
}
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
   bottom:-5px;
    left: 100%;
    margin-top: -1px;
}

.dropdown-submenu:hover > .dropdown-menu {
    display: block;
}
    </style>
<script>
document.addEventListener("DOMContentLoaded", function () {
  var postsContainer = document.querySelector(".posts-container"); 
  if (postsContainer) {
    setTimeout(() => {
      postsContainer.scrollTo({ top: postsContainer.scrollHeight, behavior: "instant" }); 
    }, 100); 
  }
});

</script>

  </head>
  <body class="bg-light min-vh-100">
    <?php

    $query = "SELECT * FROM tbl_community_msgs";
    $result = $connection->query($query);
    $username = $_SESSION['username'] ?? '';
    ?>
    <main class="py-5">
      <div class="container-xl px-4">
        <div class="d-flex align-items-center mb-4 p-3 bg-white shadow-sm rounded">
          <h3 class="me-2 mb-2 mt-2" style="font-family: 'Roboto', sans-serif; font-weight: 700;">ReRead Community</h3>
          <span class="question-mark" data-bs-toggle="tooltip" data-bs-placement="top" title="This community is directly managed by ReRead admins;">
          <i class="bi bi-exclamation-circle-fill fs-4" style="margin-left:10px;"></i>
          </span>
        </div>
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="row g-4 posts-container"> 
              <?php
              $bancheck="select userid from tbl_community where userid ='$uid' and status=1";
              $resultjoin=$connection->query($bancheck);
              if ($resultjoin->num_rows > 0) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('kickcommunity').style.display = 'block';
              
                    });
                </script>"; 
              }
              $querymyself = "SELECT * FROM tbl_users WHERE username = ?";
              $stmt = $connection->prepare($querymyself);
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $resultmyself = $stmt->get_result();
              $user = $resultmyself->fetch_assoc();
              $stmt->close();

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  if ($_SESSION['id'] == $row['userid']) {
              ?>
                <div class="col-12">
                  <div class="my-message">
                    <div class="card-body">
                      <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="<?php echo !empty($user['image']) ? '/miniproject/user/login/loginimg/' . htmlspecialchars($user['username']) . '.' . pathinfo($user['image'], PATHINFO_EXTENSION) : '/miniproject/user/login/loginimg/default-profile-pic.png'; ?>" alt="Profile Picture" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="d-flex align-items-center gap-2">
                            <p class="fw-medium mb-0"><?php echo htmlspecialchars($user['name']); ?></p>
                            <span class="badge bg-success bg-opacity-25 text-success small">You</span>
                            <div class="dropdown">
    <span class="moreopt" data-bs-toggle="dropdown">⋮</span>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item text-danger delete-message" 
               href="#" 
               data-msgid="<?php echo $row['msgid']; ?>">Delete</a></li>
    </ul>
</div>
                          </div>
                       
                        </div>
                      </div>
                      <p class="mb-3"><?php echo htmlspecialchars($row['message']); ?></p>
                      <?php if (!empty($row['image'])) { ?>
                        <div class="mb-3">
                          <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                          
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php
                  } else {
                    $oid = $row['userid'];
                    $queryothers = "SELECT * FROM tbl_users WHERE id = ?";
                    $stmt = $connection->prepare($queryothers);
                    $stmt->bind_param("i", $oid);
                    $stmt->execute();
                    $resultother = $stmt->get_result();
                    $otheruser = $resultother->fetch_assoc();
                    $stmt->close();
              ?>
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="<?php echo !empty($otheruser['image']) ? '/miniproject/user/login/loginimg/' . htmlspecialchars($otheruser['username']) . '.' . pathinfo($otheruser['image'], PATHINFO_EXTENSION) : '/miniproject/user/login/loginimg/default-profile-pic.png'; ?>" alt="Profile Picture" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="d-flex align-items-center gap-2">
                            <p class="fw-medium mb-0" style="cursor:pointer;" onclick="window.location.href ='/miniproject/user/viewprofile/viewprofile.php?request-profile=<?php echo $oid; ?>'"><?php echo htmlspecialchars($otheruser['name']); ?></p>
                          </div>
                          
                        </div>
                      </div>
                      <p class="mb-3"><?php echo htmlspecialchars($row['message']); ?></p>
                      <?php if (!empty($row['image'])) { ?>
                        <div class="mb-3">
                          <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php
                  }
                }
              }
              ?>
              </div>
              <div>
             
<div class="col-12">
  <div class="card mt-4">
    <div class="card-body">
      <form id="communityForm" enctype="multipart/form-data">
        <div class="d-flex align-items-center gap-3 input-container">
        <div class="keysearch1" id="keysearch1"></div>
          <input oninput="atrateCheck()" type="text" name="post_content" id="post_content" class="form-control flex-grow-1 rounded-pill" placeholder="Share your thoughts...">
          
          <div class="d-flex align-items-center gap-2">
            <label class="btn btn-light rounded-circle p-2">
              <i class="ri-image-line"></i>
              <input type="file" name="post_image" id="post_image" accept="image/*" class="file-input">
            </label>
            
            <button type="button" class="btn btn-light rounded-circle p-2 emoji-toggle">
              <i class="ri-emoji-sticker-line"></i>
            </button>
            <button type="submit" class="btn rounded-pill px-3" style="background: var(--primary-color); color:white;">Post</button>
            
          </div>
        </div>
        <!-- Sticker selection div - hidden by default -->
        <div class="sticker-container" style="display: none; margin-top: 15px;">
          <div class="d-flex flex-wrap gap-2">
            <img src="/miniproject/user/community/RightOnYesStickerbyKudaberi-ezgif.com-resize.gif" class="sticker" alt="Smile" style="cursor: pointer; width: 150px; height: 150px;">
            <img src="/miniproject/user/community/SadCryStickerbyKudaberi-ezgif.com-resize.gif" class="sticker" alt="Thumbs Up" style="cursor: pointer;  width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize (1).gif" class="sticker" alt="Heart" style="cursor: pointer;  width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize (2).gif" class="sticker" alt="Laugh" style="cursor: pointer;  width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize (3).gif" class="sticker" alt="Party" style="cursor: pointer;  width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize.gif" class="sticker" alt="Smile" style="cursor: pointer; width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize (4).gif" class="sticker" alt="Thumbs Up" style="cursor: pointer;  width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize (5).gif" class="sticker" alt="Heart" style="cursor: pointer;  width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize (6).gif" class="sticker" alt="Laugh" style="cursor: pointer;  width: 150px; height: 150px;">
            <img src="/miniproject/user/community/ezgif.com-resize(10).gif" class="sticker" alt="Party" style="cursor: pointer;  width: 150px; height: 150px;">
          </div>
        </div>
      </form>
      <span id="file-name" class="small" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></span>
    </div>
  </div>
</div>

                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h3 class="card-title h5 fw-semibold mb-4">Community Guidelines</h3>
                      <ul class="list-unstyled text-muted small">
                      <li class="d-flex align-items-start gap-2 mb-2">
                    <i class="ri-error-warning-line text-danger mt-1"></i>
                    <span class="fw-bold text-danger" style="font-size: 14px;">
                        If you get banned, you will not be allowed to rejoin.
                    </span>
                </li>
                        <li class="d-flex align-items-start gap-2 mb-2">
                          <i class="ri-checkbox-circle-line text-primary mt-1"></i>
                          <span>Be respectful and constructive in discussions</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-2">
                          <i class="ri-checkbox-circle-line text-primary mt-1"></i>
                          <span>No spoilers without proper warnings</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                          <i class="ri-checkbox-circle-line text-primary mt-1"></i>
                          <span>Credit authors and sources when sharing</span>
                        </li>
                      </ul>
              </div>
            </div>
            <div class="card mb-4">
              <div class="card-body">
                <h3 class="card-title h5 fw-semibold mb-4">Share & Discover</h3>
                <div class="d-flex flex-wrap gap-2">
                  <span class="badge bg-light text-dark rounded-pill px-3 py-2 cursor-pointer">Requests</span>
                  <span class="badge bg-light text-dark rounded-pill px-3 py-2 cursor-pointer">Reviews</span>
                  <span class="badge bg-light text-dark rounded-pill px-3 py-2 cursor-pointer">Recommendations</span>
                  <span class="badge bg-light text-dark rounded-pill px-3 py-2 cursor-pointer">Reading Tips</span>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <h3 class="card-title h5 fw-semibold mb-4">Active Members</h3>
                <div class="d-flex flex-column gap-4">
                  <div class="d-flex align-items-center gap-3">
                    <?php
                     $popularquery = "SELECT userid, COUNT(*) as message_count 
                     FROM tbl_community_msgs 
                     GROUP BY userid 
                     ORDER BY message_count DESC 
                     LIMIT 2";    
                     $resultpopular=$connection->query($popularquery);                 
                    if ($resultpopular) {
                      $rowpop1 = mysqli_fetch_assoc($resultpopular);
                      $rowpop2 = mysqli_fetch_assoc($resultpopular);
                    
                      $topUser1 = $rowpop1['userid'];
                      $topUser2 = $rowpop2['userid'];
                      $querynum1 = "SELECT * FROM tbl_users WHERE id = ?";
              $stmt = $connection->prepare($querynum1);
              $stmt->bind_param("i", $topUser1);
              $stmt->execute();
              $resulttop1 = $stmt->get_result();
              $usertop1 = $resulttop1->fetch_assoc();
              $stmt->close();
              $querynum2 = "SELECT * FROM tbl_users WHERE id = ?";
              $stmt = $connection->prepare($querynum2);
              $stmt->bind_param("i", $topUser2);
              $stmt->execute();
              $resulttop2 = $stmt->get_result();
              $usertop2 = $resulttop2->fetch_assoc();
              $stmt->close();
                    }
                    
                    ?>
                    <img src="<?php echo !empty($usertop1['image']) ? '/miniproject/user/login/loginimg/' . htmlspecialchars($usertop1['username']) . '.' . pathinfo($usertop1['image'], PATHINFO_EXTENSION) : '/miniproject/user/login/loginimg/default-profile-pic.png'; ?>" class="rounded-circle" width="40" height="40">
                    
                    <div>
                      <p class="mb-0 fw-medium small">
                        <?php echo $usertop1['name']; ?>
                      </p>
                      <p class="text-muted small">
                        <?php echo $usertop1['bio']; ?>
                      </p>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-3">
                  <img src="<?php echo !empty($usertop2['image']) ? '/miniproject/user/login/loginimg/' . htmlspecialchars($usertop2['username']) . '.' . pathinfo($usertop2['image'], PATHINFO_EXTENSION) : '/miniproject/user/login/loginimg/default-profile-pic.png'; ?>" class="rounded-circle" width="40" height="40">
                    <div>
                    <p class="mb-0 fw-medium small">
                        <?php echo $usertop2['name']; ?>
                      </p>
                      <p class="text-muted small">
                        <?php echo $usertop2['bio']; ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

<div class="join-community-container" id="joincommunity">
<h1><i class="bi bi-shield-lock"></i></h1>
<br>
  <h2>Welcome to ReRead Community</h2>
  <p>Join our vibrant community and connect with fellow book lovers.</p>
  <ul>
    <li>📖 Become a member and share your thoughts</li>
    <li>👥 Find expert readers and exchange insights</li>
    <li>🗣️ Discuss trending book topics with others</li>
    <li>📚 Get recommendations tailored for you</li>
  </ul>
  <h2>Join and be a part of this community</h2>
  <button onclick="window.location.href='/miniproject/user/community/communityjoin.php'">Know More</button>
</div>
<div class="join-community-container" id="kickcommunity">
<h1><i class="bi bi-shield-lock"></i></h1>
<br>
  <h2>You Have Been Banned From This Community</h2>
  <p>You are prevented from accessing this community.</p>
  <h2>The Reason Could be :</h2>
  <ul>
    <li>📖 Didn't follow community guidelines</li>
    <li>👥 Inappropriate behaviour with members</li>
    <li>🚫 Multiple reports from other users</li>
    <li>⚠️ Violated terms of service</li>
  </ul>
  <button onclick="window.location.href='/miniproject/user/welcomepage/homepage.php'">Go Back</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

let reportedMessages = {};

function atrateCheck() {
    var input = document.getElementById('post_content');
    var suggestionBox = document.getElementById('keysearch1');
    var str = input.value;
    var cursorPosition = input.selectionStart;

    var lastAtIndex = str.lastIndexOf('@', cursorPosition - 1);
    if (lastAtIndex !== -1 && str.trim() !== '@') {
        var textAfterAt = str.substring(lastAtIndex + 1, cursorPosition);
        if (!textAfterAt.includes(' ') && textAfterAt.trim() !== '') {
            suggestionBox.style.display = 'block';
            fetchUserSuggestions(textAfterAt);
            return;
        }
    }
    suggestionBox.style.display = 'none';
}

function fetchUserSuggestions(searchTerm) {
    $.ajax({
        url: '/miniproject/user/community/fetchuser.php',
        type: 'POST',
        data: { search: searchTerm },
        success: function(response) {
            $('#keysearch1').html(response);
        },
        error: function() {
            $('#keysearch1').html('<div class="keyitem">Error fetching users</div>');
        }
    });
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('keyitem1')) {
        var input = document.getElementById('post_content');
        var currentValue = input.value;
        var lastAt = currentValue.lastIndexOf('@');
        var newValue = currentValue.substring(0, lastAt + 1) + e.target.textContent + ' ';
        input.value = newValue;
        document.getElementById('keysearch1').style.display = 'none';
    }
});

document.getElementById('post_content').addEventListener('input', atrateCheck);

document.addEventListener("DOMContentLoaded", function () {
    const emojiToggle = document.querySelector('.emoji-toggle');
    const inputContainer = document.querySelector('.input-container');
    const stickerContainer = document.querySelector('.sticker-container');
    const postContent = document.getElementById('post_content');
    const postImage = document.getElementById('post_image');
    const fileNameDisplay = document.getElementById('file-name');
    let selectedStickerSrc = '';

    postImage.addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = '';
        }
    });

    var postsContainer = document.querySelector(".posts-container");
    if (postsContainer) {
        setTimeout(() => {
            postsContainer.scrollTo({ top: postsContainer.scrollHeight, behavior: "instant" });
        }, 100);
    }

    
    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-message')) {
            e.preventDefault();
            const deleteLink = e.target;
            const msgid = deleteLink.getAttribute('data-msgid');
            const messageElement = deleteLink.closest('.col-12');

            $.ajax({
                url: '/miniproject/user/community/communityenter.php',
                type: 'GET',
                data: { msgid: msgid },
                dataType: 'json',
                beforeSend: function() {
                    deleteLink.textContent = 'Deleting...';
                    deleteLink.setAttribute('disabled', 'true');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        if (messageElement) {
                            messageElement.style.transition = 'opacity 0.3s';
                            messageElement.style.opacity = '0';
                            setTimeout(() => {
                                messageElement.remove();
                            }, 300);
                        }
                    } else {
                        Swal.fire('Error', 'Failed to delete message: ' + (response.message || 'Unknown error'), 'error');
                        deleteLink.textContent = 'Delete';
                        deleteLink.removeAttribute('disabled');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Error deleting message: ' + error, 'error');
                    deleteLink.textContent = 'Delete';
                    deleteLink.removeAttribute('disabled');
                }
            });
        }
    });

    
    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('report-message')) {
            e.preventDefault();
            const reportLink = e.target;
            const msgid = reportLink.getAttribute('data-msgid');

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to report this message?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, report it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/miniproject/user/community/reportmessage.php',
                        type: 'POST',
                        data: { 
                            msgid: msgid,
                            reported_by: "<?php echo $_SESSION['id']; ?>",
                            reason: 'general' 
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            reportLink.textContent = 'Reporting...';
                            reportLink.setAttribute('disabled', 'true');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Reported!', 'Message reported successfully! We will take necessary actions.', 'success');
                                reportedMessages[msgid] = true;
                                reportLink.textContent = 'Reported';
                                reportLink.classList.remove('text-danger');
                                reportLink.classList.add('text-muted');
                                reportLink.removeAttribute('href');
                                reportLink.removeAttribute('disabled');
                            } else {
                                Swal.fire('Error', 'Failed to report message: ' + (response.message || 'Unknown error'), 'error');
                                reportLink.textContent = 'Report';
                                reportLink.removeAttribute('disabled');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Error reporting message: ' + error, 'error');
                            reportLink.textContent = 'Report';
                            reportLink.removeAttribute('disabled');
                        }
                    });
                }
            });
        }
    });

   
    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('report-reason')) {
            e.preventDefault();
            const reportLink = e.target;
            const msgid = reportLink.getAttribute('data-msgid');
            const reason = reportLink.getAttribute('data-reason');

            Swal.fire({
                title: 'Report Message',
                text: `Are you sure you want to report this message as "${reason}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, report it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/miniproject/user/community/reportmessage.php',
                        type: 'POST',
                        data: { 
                            msgid: msgid,
                            reported_by: "<?php echo $_SESSION['id']; ?>",
                            reason: reason
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            reportLink.textContent = 'Reporting...';
                            reportLink.setAttribute('disabled', 'true');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Reported!', `Message reported as "${reason}" successfully! We will take necessary actions.`, 'success');
                                reportedMessages[msgid] = true;
                                reportLink.textContent = 'Reported';
                                reportLink.classList.remove('text-danger');
                                reportLink.classList.add('text-muted');
                                reportLink.removeAttribute('href');
                                reportLink.removeAttribute('disabled');
                            } else {
                                Swal.fire('Error', 'Failed to report message: ' + (response.message || 'Unknown error'), 'error');
                                reportLink.textContent = reason.charAt(0).toUpperCase() + reason.slice(1); // Reset to original text
                                reportLink.removeAttribute('disabled');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Error reporting message: ' + error, 'error');
                            reportLink.textContent = reason.charAt(0).toUpperCase() + reason.slice(1); // Reset to original text
                            reportLink.removeAttribute('disabled');
                        }
                    });
                }
            });
        }
    });

    emojiToggle.addEventListener('click', function () {
        const isActive = this.classList.toggle('active');
        if (isActive) {
            inputContainer.style.display = 'none';
            stickerContainer.style.display = 'block';
        } else {
            inputContainer.style.display = 'flex';
            stickerContainer.style.display = 'none';
            selectedStickerSrc = '';
        }
    });

    document.querySelectorAll('.sticker').forEach(sticker => {
        sticker.addEventListener('click', function () {
            selectedStickerSrc = this.src;
            stickerContainer.querySelectorAll('.sticker').forEach(s => s.style.border = 'none');
            this.style.border = '2px solid #0d6efd';

            fetch(selectedStickerSrc)
                .then(response => response.blob())
                .then(blob => {
                    var formData = new FormData();
                    formData.append('sticker_image', blob, 'sticker.png');
                    var username = "<?php echo $_SESSION['username']; ?>";
                    if (username === '') {
                        window.location.href = "/miniproject/user/login/login.php";
                        return;
                    }

                    $.ajax({
                        url: "/miniproject/user/community/communityenter.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            selectedStickerSrc = '';
                            emojiToggle.classList.remove('active');
                            inputContainer.style.display = 'flex';
                            stickerContainer.style.display = 'none';
                            stickerContainer.querySelectorAll('.sticker').forEach(s => s.style.border = 'none');
                            fetchMessages(true);
                        },
                        error: function () {
                            Swal.fire('Error', 'Failed to send sticker!', 'error');
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching sticker image:', error);
                    Swal.fire('Error', 'Failed to process sticker!', 'error');
                });
        });
    });

    $("#communityForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var username = "<?php echo $_SESSION['username']; ?>";
        if (username === '') {
            window.location.href = "/miniproject/user/login/login.php";
            return;
        }

        var msg = postContent.value;
        var img = postImage.files.length > 0 ? postImage.files[0] : '';
        if (msg === '' && !img) {
            return;
        }

        $.ajax({
            url: "/miniproject/user/community/communityenter.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $("#post_content").val("");
                $("#post_image").val("");
                fileNameDisplay.textContent = '';
                fetchMessages(true);
            },
            error: function () {
                Swal.fire('Error', 'Failed to send message!', 'error');
            }
        });
    });

    function fetchMessages(userPosted = false) {
        $.ajax({
            url: "/miniproject/user/community/check_community_status.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'banned') {
                    $('#kickcommunity').css('display', 'block');
                    $('.posts-container').html('');
                    return;
                } else if (response.status === 'notjoined') {
                    $('#joincommunity').css('display', 'block');
                    $('.posts-container').html('');
                    return;
                } else {
                    $('#kickcommunity').css('display', 'none');
                }

                $.ajax({
                    url: "/miniproject/user/community/fetch_msg.php",
                    type: "GET",
                    success: function (data) {
                        $(".posts-container").html(data);
                        
                        Object.keys(reportedMessages).forEach(msgid => {
                            const reportLink = document.querySelector(`.report-message[data-msgid="${msgid}"]`);
                            if (reportLink) {
                                reportLink.textContent = 'Reported';
                                reportLink.classList.remove('text-danger');
                                reportLink.classList.add('text-muted');
                                reportLink.removeAttribute('href');
                            }
                           
                            document.querySelectorAll(`.report-reason[data-msgid="${msgid}"]`).forEach(link => {
                                link.textContent = 'Reported';
                                link.classList.remove('text-danger');
                                link.classList.add('text-muted');
                                link.removeAttribute('href');
                            });
                        });
                        if (userPosted) {
                            var postsContainer = document.querySelector(".posts-container");
                            if (postsContainer) {
                                postsContainer.scrollTo({ 
                                    top: postsContainer.scrollHeight, 
                                    behavior: "smooth" 
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error fetching messages:', error);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log('Error checking status:', error);
            }
        });
    }

  
    fetchMessages();
 
    setInterval(() => fetchMessages(false), 7000);
});
</script>

  </body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>