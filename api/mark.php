<?php require __DIR__.'/../config/bootstrap.php'; $d=input();$id=(int)($d['employee_id']??0);$pin=(string)($d['pin']??'');
$st=$pdo->prepare('SELECT id,pin_hash FROM employees WHERE id=? AND active=1');$st->execute([$id]);$e=$st->fetch();if(!$e||!password_verify($pin,$e['pin_hash'])) out(['ok'=>false,'error'=>'PIN incorrecto. No se registró ninguna marcación.'],401);
$tz=$pdo->query('SELECT timezone FROM settings WHERE id=1')->fetchColumn() ?: 'America/El_Salvador';date_default_timezone_set($tz);$date=date('Y-m-d');$now=date('Y-m-d H:i:s');
$pdo->beginTransaction();$st=$pdo->prepare('SELECT id,clock_in,clock_out FROM attendance WHERE employee_id=? AND work_date=? FOR UPDATE');$st->execute([$id,$date]);$r=$st->fetch();
if(!$r){$st=$pdo->prepare('INSERT INTO attendance(employee_id,work_date,clock_in) VALUES(?,?,?)');$st->execute([$id,$date,$now]);$type='Entrada';}
elseif(!$r['clock_out']){$st=$pdo->prepare('UPDATE attendance SET clock_out=? WHERE id=?');$st->execute([$now,$r['id']]);$type='Salida';}
else{$pdo->rollBack();out(['ok'=>false,'error'=>'El turno de hoy ya fue completado'],409);} $pdo->commit();out(['ok'=>true,'type'=>$type,'time'=>$now]);
