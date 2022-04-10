# Zepto_Ecommerce

## API Documentation

### Login
link: /api/user/login.php<br>
method: POST<br>
data: raw data {'username', 'password'}<br>
response: {'status', 'message', and 'jwtoken' if success}<br>


### Registration
link: /api/user/rergister.php<br>
method: POST<br>
data: raw data {'name', 'email', 'username', 'password'}<br>
response: {'status', 'message'}<br>

### Add Product
link: /api/product/add.php<br>
method: POST<br>
header: pass jwtoken as 'Authentication'<br>
data: form data {'name', 'price', 'image' as file}<br>
response: {'status', 'message'}<br>

### List Product
link: /api/product/get.php<br>
method: GET<br>
header: pass jwtoken as 'Authentication'<br>
data: query params {'name' which is optional}<br>
response: {'status', 'message', 'data' if success}<br>

### Update Product
link: /api/product/add.php<br>
method: POST<br>
header: pass jwtoken as 'Authentication'<br>
data: form data {'name', 'price', 'image' as file, 'id'}<br>
response: {'status', 'message'}<br>

### Delete Product
link: /api/product/add.php<br>
method: DELETE<br>
header: pass jwtoken as 'Authentication'<br>
data: form data {'id'}<br>
response: {'status', 'message'}<br>
