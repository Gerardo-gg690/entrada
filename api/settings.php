<?php require __DIR__.'/../config/bootstrap.php'; admin_required();$d=input();csrf_check($d);
$salary=max(0,(float)($d['salary']??0));$half=max(0,(float)($d['half_salary']??0));$days=max(1,min(31,(int)($d['paid_days']??30)));$hours=max(.5,min(24,(float)($d['normal_hours']??8)));$extra=max(0,(float)($d['extra_rate']??0));
$st=$pdo->prepare('UPDATE settings SET salary=?,half_salary=?,paid_days=?,normal_hours=?,extra_rate=? WHERE id=1');$st->execute([$salary,$half,$days,$hours,$extra]);out(['ok'=>true]);
