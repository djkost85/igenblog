<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>เข้าระบบ :: IGenGoods</title>

<!-- Favicon -->
<link rel="shortcut icon" href="image/favicon/icon.ico" />

<!-- Style File -->
<link rel="stylesheet" href="css/reset.css" type="text/css"/>
<link rel="stylesheet" href="css/login.css" type="text/css"/>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

<!-- LIB -->
<script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>

</head>

<body>
  <div id="login">
    <div class="title">
      <i class="fa fa-leaf"></i> IGENBLOG
    </div>
    
    <form action="index.php?e=loginG" target="_parent" method="POST">
      <input type="text" name="username" class="input-text" placeholder="username" autofocus>
      <input type="password" name="password" class="input-text" placeholder="password">
      <?php if($_GET['e'] == 'fail'){?>
        <div class="alert"><i class="fa fa-exclamation-circle"></i> ตรวจสอบ Username หรือ Password อีกครั้ง</div>
      <?php }?>
      <input type="submit" class="input-submit" value="เข้าระบบ">
    </form>
    
    <p>Version 3.0</p>
  </div>
</body>
</html>