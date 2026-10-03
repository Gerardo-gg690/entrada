<?php require __DIR__.'/../config/bootstrap.php'; $d=input(); $action=$d['action']??'';
if($action==='create'){
 if((bool)$pdo->query('SELECT EXISTS(SELECT 1 FROM admins)')->fetchColumn()) out(['ok'=>false,'error'=>'La cuenta administradora ya fue creada'],409);
 $u=trim((string)($d['username']??''));$p=(string)($d['password']??'');
 if(mb_strlen($u)<3||strlen($p)<6) out(['ok'=>false,'error'=>'Usuario mínimo 3 caracteres y contraseña mínimo 6'],422);
 $st=$pdo->prepare('INSERT INTO admins(username,password_hash) VALUES(?,?)');$st->execute([$u,password_hash($p,PASSWORD_DEFAULT)]);$_SESSION['admin_id']=(int)$pdo->lastInsertId();out(['ok'=>true,'csrf'=>csrf()]);
}
if($action==='login'){
 $st=$pdo->prepare('SELECT id,password_hash FROM admins WHERE username=?');$st->execute([trim((string)($d['username']??''))]);$a=$st->fetch();
 if(!$a||!password_verify((string)($d['password']??''),$a['password_hash'])) out(['ok'=>false,'error'=>'Usuario o contraseña incorrectos'],401);
 session_regenerate_id(true);$_SESSION['admin_id']=(int)$a['id'];out(['ok'=>true,'csrf'=>csrf()]);
}
if($action==='logout'){session_destroy();out(['ok'=>true]);}
out(['ok'=>false,'error'=>'Acción inválida'],400);
