$host = getenv('db_host');
$user = getenv('db_user');
$password = getenv('db_pass');
$dbname = getenv('db_name');

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
