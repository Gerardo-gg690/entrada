<?php require __DIR__.'/../config/bootstrap.php';
$employees=$pdo->query("SELECT id,name,department FROM employees WHERE active=1 ORDER BY name")->fetchAll();
$s=$pdo->query("SELECT salary,half_salary,paid_days,normal_hours,extra_rate,timezone FROM settings WHERE id=1")->fetch();
$from=$_GET['from']??date('Y-m-01'); $to=$_GET['to']??date('Y-m-t');
$st=$pdo->prepare("SELECT employee_id,work_date,clock_in,clock_out FROM attendance WHERE work_date BETWEEN ? AND ? ORDER BY work_date");$st->execute([$from,$to]);
out(['ok'=>true,'employees'=>$employees,'settings'=>$s,'records'=>$st->fetchAll(),'adminExists'=>(bool)$pdo->query('SELECT EXISTS(SELECT 1 FROM admins)')->fetchColumn(),'adminLoggedIn'=>!empty($_SESSION['admin_id']),'csrf'=>csrf()]);
