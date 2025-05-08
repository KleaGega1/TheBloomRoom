<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">Categories</h1>
        @if(isset($categories) && $categories->isNotEmpty())
            <div class="list-group">
                @foreach ($categories as $category)
                    <div class="list-group-item">
                        <h5 class="mb-1">{{ $category->name }}</h5>
                        @if($category->children->isNotEmpty())
                            <ul class="list-unstyled ms-3">
                                @foreach ($category->children as $child)
                                    <li class="mb-1">
                                        <i class="fas fa-angle-right text-primary me-2"></i>{{ $child->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">No categories available.</p>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>