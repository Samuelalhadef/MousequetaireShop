# Test API Endpoints

Write-Host "`n=== Testing Mousquetaire Shop API ===`n" -ForegroundColor Green

# Test 1: Login as admin
Write-Host "1. Login as admin..." -ForegroundColor Yellow
$loginResponse = Invoke-RestMethod -Uri "http://localhost:8080/api/login" `
    -Method Post `
    -ContentType "application/json" `
    -Body '{"email":"admin@shop.com","password":"admin123"}' `
    -ErrorAction SilentlyContinue

if ($loginResponse.token) {
    Write-Host "    Login successful!" -ForegroundColor Green
    $token = $loginResponse.token
} else {
    Write-Host "    Login failed" -ForegroundColor Red
    exit 1
}

# Test 2: Get products
Write-Host "`n2. Fetching products..." -ForegroundColor Yellow
$headers = @{
    "Authorization" = "Bearer $token"
    "Accept" = "application/json"
}

$products = Invoke-RestMethod -Uri "http://localhost:8080/api/products" `
    -Headers $headers `
    -ErrorAction SilentlyContinue

if ($products) {
    $count = $products.'hydra:member'.Count
    Write-Host "    Found $count products" -ForegroundColor Green
    Write-Host "   Sample: $($products.'hydra:member'[0].name)" -ForegroundColor Cyan
} else {
    Write-Host "    Failed to fetch products" -ForegroundColor Red
}

# Test 3: Get categories
Write-Host "`n3. Fetching categories..." -ForegroundColor Yellow
$categories = Invoke-RestMethod -Uri "http://localhost:8080/api/categories" `
    -Headers $headers `
    -ErrorAction SilentlyContinue

if ($categories) {
    $count = $categories.'hydra:member'.Count
    Write-Host "    Found $count categories" -ForegroundColor Green
} else {
    Write-Host "    Failed to fetch categories" -ForegroundColor Red
}

Write-Host "`n=== All tests passed! ===`n" -ForegroundColor Green
Write-Host "Access the API documentation at: http://localhost:8080/api/docs" -ForegroundColor Cyan
