# API Request/Response Examples

All examples match the Java backend exactly.

## Authentication

### Register
**Request:**
```http
POST /api/auth/register
Content-Type: application/json

{
  "fullName": "John Doe",
  "phone": "+1234567891",
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "type": "Bearer",
    "id": 2,
    "fullName": "John Doe",
    "phone": "+1234567891",
    "email": "john@example.com",
    "roles": ["CUSTOMER"]
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

### Login
**Request:**
```http
POST /api/auth/login
Content-Type: application/json

{
  "phone": "+1234567890",
  "password": "admin123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "type": "Bearer",
    "id": 1,
    "fullName": "Admin User",
    "phone": "+1234567890",
    "email": "admin@foodordering.com",
    "roles": ["ADMIN"]
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

### Get Profile
**Request:**
```http
GET /api/auth/profile
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "id": 1,
    "fullName": "Admin User",
    "phone": "+1234567890",
    "email": "admin@foodordering.com",
    "active": true,
    "roles": ["ADMIN"],
    "createdAt": "2024-01-01T00:00:00Z",
    "updatedAt": "2024-01-01T00:00:00Z"
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

## Food Items

### Get All Food Items
**Request:**
```http
GET /api/foods?page=0&size=20
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "content": [
      {
        "id": 1,
        "name": "Margherita Pizza",
        "description": "Classic pizza with tomato sauce, mozzarella, and fresh basil",
        "price": "12.99",
        "imageUrl": "https://example.com/pizza-margherita.jpg",
        "active": true,
        "featured": true,
        "stockQuantity": 50,
        "category": "Pizza",
        "averageRating": 0.0,
        "reviewCount": 0,
        "createdAt": "2024-01-01T00:00:00Z",
        "updatedAt": "2024-01-01T00:00:00Z"
      }
    ],
    "totalElements": 15,
    "totalPages": 1,
    "size": 20,
    "number": 0
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

### Get Featured Food Items
**Request:**
```http
GET /api/foods/featured
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": [
    {
      "id": 1,
      "name": "Margherita Pizza",
      "description": "Classic pizza...",
      "price": "12.99",
      "featured": true,
      ...
    }
  ],
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

## Cart

### Add to Cart
**Request:**
```http
POST /api/cart
Authorization: Bearer {token}
Content-Type: application/json

{
  "foodItemId": 1,
  "quantity": 2
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Item added to cart",
  "data": {
    "id": 1,
    "userId": 2,
    "items": [
      {
        "id": 1,
        "foodItemId": 1,
        "foodItemName": "Margherita Pizza",
        "foodItemImageUrl": "https://example.com/pizza-margherita.jpg",
        "foodItemPrice": "12.99",
        "quantity": 2,
        "subtotal": "25.98",
        "createdAt": "2024-01-15T10:30:00Z"
      }
    ],
    "totalAmount": "25.98",
    "totalItems": 2,
    "createdAt": "2024-01-15T10:30:00Z",
    "updatedAt": "2024-01-15T10:30:00Z"
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

### Get Cart
**Request:**
```http
GET /api/cart
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "id": 1,
    "userId": 2,
    "items": [...],
    "totalAmount": "25.98",
    "totalItems": 2,
    ...
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

## Orders

### Create Order
**Request:**
```http
POST /api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "deliveryAddress": "123 Main St, City, State 12345",
  "phone": "+1234567891",
  "notes": "Please ring the doorbell"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "orderNumber": "ORD-ABC12345-12345",
    "userId": 2,
    "userName": "John Doe",
    "items": [
      {
        "id": 1,
        "foodItemId": 1,
        "foodItemName": "Margherita Pizza",
        "foodItemImageUrl": "https://example.com/pizza-margherita.jpg",
        "quantity": 2,
        "unitPrice": "12.99",
        "subtotal": "25.98"
      }
    ],
    "totalAmount": "25.98",
    "status": "PENDING",
    "deliveryAddress": "123 Main St, City, State 12345",
    "phone": "+1234567891",
    "notes": "Please ring the doorbell",
    "createdAt": "2024-01-15T10:30:00Z",
    "updatedAt": "2024-01-15T10:30:00Z"
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

### Get My Orders
**Request:**
```http
GET /api/orders/my?page=0&size=20
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "content": [
      {
        "id": 1,
        "orderNumber": "ORD-ABC12345-12345",
        "status": "PENDING",
        "totalAmount": "25.98",
        ...
      }
    ],
    "totalElements": 1,
    "totalPages": 1,
    "size": 20,
    "number": 0
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

## Reviews

### Get Reviews
**Request:**
```http
GET /api/foods/1/reviews?page=0&size=10
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "content": [
      {
        "id": 1,
        "foodItemId": 1,
        "userId": 2,
        "userName": "John Doe",
        "rating": 5,
        "comment": "Excellent food!",
        "createdAt": "2024-01-15T10:30:00Z",
        "updatedAt": "2024-01-15T10:30:00Z"
      }
    ],
    "totalElements": 1,
    "totalPages": 1,
    "size": 10,
    "number": 0
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

### Create Review
**Request:**
```http
POST /api/foods/1/reviews
Authorization: Bearer {token}
Content-Type: application/json

{
  "rating": 5,
  "comment": "Excellent food!"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Review created successfully",
  "data": {
    "id": 1,
    "foodItemId": 1,
    "userId": 2,
    "userName": "John Doe",
    "rating": 5,
    "comment": "Excellent food!",
    "createdAt": "2024-01-15T10:30:00Z",
    "updatedAt": "2024-01-15T10:30:00Z"
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

## Admin

### Get Dashboard
**Request:**
```http
GET /api/admin/dashboard
Authorization: Bearer {admin_token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "totalOrders": 10,
    "pendingOrders": 2,
    "completedOrders": 8,
    "totalRevenue": "250.00",
    "totalCustomers": 5,
    "totalFoodItems": 15,
    "activeFoodItems": 15
  },
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

### Get Daily Report
**Request:**
```http
GET /api/admin/reports/daily
Authorization: Bearer {admin_token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Success",
  "data": [
    {
      "date": "2024-01-01",
      "totalOrders": 5,
      "totalRevenue": "125.00",
      "totalCost": "0.00",
      "profit": "125.00",
      "totalItemsSold": 0
    },
    ...
  ],
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": null
}
```

## Error Responses

### Validation Error (400)
```json
{
  "success": false,
  "message": "Validation failed",
  "data": null,
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": "VALIDATION_ERROR"
}
```

### Resource Not Found (404)
```json
{
  "success": false,
  "message": "Food item not found with id: 999",
  "data": null,
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": "RESOURCE_NOT_FOUND"
}
```

### Unauthorized (401)
```json
{
  "success": false,
  "message": "Invalid phone number or password",
  "data": null,
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": "UNAUTHORIZED"
}
```

### Forbidden (403)
```json
{
  "success": false,
  "message": "Access denied",
  "data": null,
  "timestamp": "2024-01-15T10:30:00Z",
  "errorCode": "FORBIDDEN"
}
```

