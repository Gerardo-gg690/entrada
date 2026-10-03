<?php require __DIR__.'/../config/bootstrap.php'; admin_required(); $d=input(); csrf_check($d); $action=$d['action']??'';
if($action==='add'){
 $name=trim((string)($d['name']??''));$dept=trim((string)($d['department']??''));$pin=(string)($d['pin']??'');
 if($name===''||!preg_match('/^\d{4,6}$/',$pin)) out(['ok'=>false,'error'=>'Nombre requerido y PIN de 4 a 6 números'],422);
 $st=$pdo->prepare('INSERT INTO employees(name,department,pin_hash) VALUES(?,?,?)');$st->execute([$name,$dept?:null,password_hash($pin,PASSWORD_DEFAULT)]);out(['ok'=>true,'id'=>(int)$pdo->lastInsertId()]);
}
if($action==='delete'){ $id=(int)($d['id']??0);$st=$pdo->prepare('DELETE FROM employees WHERE id=?');$st->execute([$id]);out(['ok'=>true]); }
out(['ok'=>false,'error'=>'Acción inválida'],400);
