<?php
declare(strict_types=1);
session_start([
 'cookie_httponly'=>true,
 'cookie_samesite'=>'Lax',
 'cookie_secure'=>(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
]);
require __DIR__.'/database.php';
header('Content-Type: application/json; charset=utf-8');
function input(): array { $raw=file_get_contents('php://input'); $d=json_decode($raw?:'{}',true); return is_array($d)?$d:[]; }
function out(array $x,int $status=200): never { http_response_code($status); echo json_encode($x,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); exit; }
function admin_required(): void { if(empty($_SESSION['admin_id'])) out(['ok'=>false,'error'=>'Sesión administrativa requerida'],401); }
function csrf(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(24)); return $_SESSION['csrf']; }
function csrf_check(array $d): void { if(!hash_equals($_SESSION['csrf']??'', (string)($d['csrf']??''))) out(['ok'=>false,'error'=>'Solicitud inválida'],403); }
