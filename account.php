<?php
require "common.php";
$profile_pic = isset($_SESSION["profilepic"]) ? $_SESSION["profilepic"] : "images/user_icon.png";
?>

<html>
<head>
<link href="css/default.css" rel="stylesheet" type="text/css">
<style>
.profile {
    width:600px;
    margin-left:325px;
}
.form-heading {
    color:#6200A3;
}
#profile-pic {
    max-width:80px;
    max-height:80px;
    -webkit-border-radius: 80px;
    -moz-border-radius: 80px;
    border-radius: 80px;
}
#profilepic-container {
    text-align:center;
    margin-bottom:20px;
}
.sub-heading {
    color:#6200A3;
    font-style:italic;
    font-size:12px;
    margin-top:-20px;
}
#security-row {
    display:none;
}
#profile-pic:hover {
    background:#000;
    opacity: 0.2;
    -webkit-transition-duration: 0.5s;
    -moz-transition-duration: 0.5s;
}
#profilePicModal {
    height:300px;
    width:300px;
}
#simplemodal-overlay {
    background: #000;
}
</style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-main">
        <div class="title">
            <?= $_SESSION["title"] ?>.
        </div>
        <div class="img-container">
            <img class="sidebar-image" src="{image:Sidebar Image}">
        </div>

            <div class="description">
               <?= "(description)" ?>
            </div>

        <nav class="links">
            <ul>
  				<!--make "new" and "account" viewable only to the person logged in -->
                <li><a href="/main.php">home</a></li>
                <li><a href="/account.php">account</a></li>
                <li><a href="contact.php">contact</a></li>
                <li><a href="logout.php">log out</a></li>
            </ul>
        </nav>
    </div>
</aside>
	
    <div class="profile content">
        <h2 class="form-heading">General</h2>
        <p class ="sub-heading">Display settings for general look and feel of blog.</p>
        <form name="profile" id="profile" method="post" action="process_profile.php">
            <div id="profilepic-container">
                <a href="#" onClick="openEditProfPicModal(); return false;" ><img id="profile-pic" title="Change Profile Picture" src="<?= $profile_pic ?>" alt="images/user_icon.png"></img></a>
            </div>
            <div class="inputs row">
                <div class="col">
                    <label class="control-label">Blog Title:</label>
                    <input type="text" class="control-text xlg" value="(blog title here)" id="blog-title" name="blog-title">
                </div>
                <div class="col">
                    <label class="control-label">Username:</label>
                    <input type="text" class="control-text xlg" value="(username here)" id="username" name="username">
                </div>
             </div>
             <div style="margin-bottom:20px"></div>
             <div class="inputs" style="text-align:center">
                <button type="submit" class="btn confirm">Save Changes</button>
            </div>
        </form>
         <hr>
         <h2 class="form-heading">Security</h2>
         <p class ="sub-heading">Password and E-mail Changes</p>
         <div id="secpass-section">
             <div class="inputs" id="secpass-section">
                <label class="control-label"><i>Please enter current password to continue:</i></label>
                <input type="password" class="control-text lg" name="sec-pass" id="sec-pass"> 
            </div>
            <div class="inputs">
                <button type="button" class="btn warn" onClick="checkPassword()">Verify</button>
            </div>
            <img src="images/loading.gif" style="display:none" id="loading-gif"></img>
        </div>
        <div style="margin-bottom:20px"></div>
        <form name="security-form" id="security-form" method="post" action="process_security.php"> 
            <div id="security-row">
                <div class="inputs row">
                    <label class="control-label">Change E-mail:</label>
                    <input type="text" name="email" id="email" class="control-text lg" placeholder="New E-mail Address">
                </div>
                <div style="margin-bottom:20px"></div>
                <label class="control-label">Change Password:</label>
            
                <div class="inputs row">
                    <input type="password" placeholder="Enter New Password" class="control-text lg" name="pass1" id="pass1" class="control-text lg">
                </div>
                <div class="inputs row">
                    <input type="password" placeholder="Re-enter Password" class="control-text lg" name="pass2" id="pass2" class="control-text lg">
                </div>
                <div class="inputs" style="text-align:center">
                    <button type="submit" class="btn confirm">Save Changes</button>
                </div>
            </div>
        </form>
    </div>


    <!-- jQuery, misc js -->
    <script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="js/jquery.simplemodal-1.4.4.js" type="text/javascript"></script>
    <script type="text/javascript">
        function checkPassword() {
            $("#loading-gif").show();
            $.ajax({
                url: "acct-check_pass.php",
                type: "GET",
                data: {password: $("#sec-pass").val()},
                success: function(result) {
                    $("#sec-pass").val("");
                    $("#loading-gif").hide();
                    if (result) {
                        $("#secpass-section").fadeOut(500).hide();
                        $("#security-row").fadeIn(500).show();
                    }
                }
            });
        }

        function openEditProfPicModal() {
            $("#profilePicModal").fadeIn(500).modal({
                opacity:50, 
                overlayClose:true,
                position: ["20%", "20%"]
            });
        }
    </script>
</body>
<div class="content" id="profilePicModal" style="display:none">
    <h2 class="form-heading">Update Avatar</h2>
    <p class="sub-heading">Avatar will be resized to 125x125 pixels.</p>
    <form name="upd_profpic" id="upd_profpic" method="post" action="update_avatar.php">
        <div style="text-align:center">
            <img src="<?= $profile_pic ?>">
            <input type="file" class="btn warn" class="control-text lg" placeholder="Upload Profile Picture">
            <div><button type="submit" class="btn confirm">Upload</button></div>
        </div>
    </form>
</div>

</html>