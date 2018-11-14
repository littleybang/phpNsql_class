fetch('http://localhost/ec_example/login_api.php',{
    method: "POST",
    mode: "cors",
    headers: {
        // "Content-Type": "application/json; charset=utf-8",
        "Content-Type": "application/x-www-form-urlencoded",
    },
    body: 'email=1114@today.com&password=1114'
});