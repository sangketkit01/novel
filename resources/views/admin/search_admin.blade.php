@extends('admin.home')

@section('title', 'ผลการค้นหา')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <style>
                /* สไตล์หลัก */
                body {
                    background-color: #f9f9f9;
                    font-family: 'Kanit', Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                .container {
                    max-width: 1200px;
                    margin: 40px auto;
                    padding: 20px;
                }

                /* สไตล์สำหรับฟอร์มค้นหา */
                .search-form {
                    display: flex;
                    align-items: center;
                    border-radius: 25px;
                    background-color: white;
                    padding: 5px 10px;
                    border: 1px solid #ccc;
                    margin-bottom: 20px;
                }

                .search-input {
                    border: none;
                    border-radius: 25px;
                    padding: 10px;
                    font-size: 16px;
                    outline: none;
                    flex-grow: 1;
                }

                .search-button {
                    background: none;
                    border: none;
                    cursor: pointer;
                    padding: 5px;
                }

                .search-button img {
                    vertical-align: middle;
                }

                .search-input::placeholder {
                    color: #999;
                }

                /* สไตล์สำหรับผลการค้นหา */
                .result {
                    font-size: 18px;
                    margin-bottom: 20px;
                    color: #333;
                }

                .recommend-section1 {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .recommend-card-link {
            text-decoration: none;
            color: inherit;
            flex-basis: calc(50% - 10px); /* สองคอลัมน์ */
            max-width: calc(50% - 10px); /* สองคอลัมน์ */
        }

                .recommend-card {
                    display: flex;
                    background-color: #fff;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                    transition: transform 0.3s ease-in-out;
                }

                .recommend-card:hover {
                    transform: translateY(-5px);
                }

                .recommend-card img {
                    width: 150px;
                    height: 200px;
                    object-fit: cover;
                }

                .card-body {
                    padding: 15px;
                    flex-grow: 1;
                }

                .card-title {
                    font-size: 18px;
                    margin: 0 0 10px 0;
                    color: #333;
                }

                .card-text {
                    font-size: 14px;
                    color: #666;
                    margin-bottom: 5px;
                }

                /* สไตล์สำหรับการแบ่งหน้า */
                .pagination {
                    display: flex;
                    justify-content: center;
                    list-style: none;
                    padding: 0;
                    margin-top: 20px;
                }

                .pagination li {
                    margin: 0 5px;
                }

                .pagination li a,
                .pagination li span {
                    display: block;
                    padding: 8px 12px;
                    background-color: #fff;
                    border: 1px solid #ddd;
                    color: #333;
                    text-decoration: none;
                    border-radius: 4px;
                }

                .pagination li.active span {
                    background-color: #007bff;
                    color: #fff;
                    border-color: #007bff;
                }
                .back-button {
    background-color: #4F5D87; /* สีพื้นหลัง */
    color: white; /* สีข้อความ */
    padding: 10px; /* ขนาด padding */
    border: none; /* ไม่มีกรอบ */
    border-radius: 50%; /* ทำให้ปุ่มเป็นวงกลม */
    cursor: pointer; /* แสดงว่าปุ่มสามารถคลิกได้ */
    font-size: 16px; /* ขนาดฟอนต์ */
    transition: background-color 0.3s; /* เปลี่ยนสีอย่างนุ่มนวล */
    display: flex; /* จัดแนวให้เป็น flex */
    align-items: center; /* จัดแนวกลางในแนวตั้ง */
    justify-content: center; /* จัดแนวกลางในแนวนอน */
    width: 37px; /* ขนาดความกว้างของปุ่ม */
    height: 37px; /* ขนาดความสูงของปุ่ม */
    margin-bottom: 0px; /* เพิ่มระยะห่างด้านล่าง */
    margin-top: 2.5%; 
    margin-left: 2.5%;
}

.back-button i {
    margin: 0; /* ไม่ต้องมีระยะห่างระหว่างไอคอนกับขอบ */
}

.back-button:hover {
    background-color: #c2c2c2; /* สีเมื่อ hover */
}

                /* สไตล์สำหรับหน้าจอขนาดเล็ก */
                @media (max-width: 768px) {
                    .recommend-card-link {
                        flex-basis: 100%;
                        max-width: 100%;
                    }

                    .recommend-card {
                        flex-direction: column;
                    }

                    .recommend-card img {
                        width: 100%;
                        height: 200px;
                    }
                }
            </style>
@endpush

@section('content')
    <button onclick="window.history.back();" class="back-button">
        <i class="fas fa-arrow-left"></i> <!-- ตัวอย่างไอคอนจาก Font Awesome -->
    </button>
<div class="container">
    <div class="row">
        <form action="{{ route('admin.search_admin') }}" method="GET" class="search-form">
            <input type="text" name="query" placeholder="ค้นหา..." class="search-input" value="{{ $query }}">
            <button type="submit" class="search-button">
                <img src="{{ asset('nav/search.svg') }}" width="20" height="20" alt="Search">
            </button>
        </form>
        <div>
            <p class="result">ผลการค้นหาสำหรับ: "{{ htmlspecialchars($query) }}"</p>
        </div>
        @if ($books->isEmpty())
            <p>ไม่พบหนังสือตามที่ค้นหา</p>
        @else
            <div class="recommend-section1">
                @foreach ($books as $novel)
                    <a href="{{ route('admin.book_detail', ['bookID' => $novel->bookID])}}" class="recommend-card-link">
                        <div class="recommend-card">
                            <img src="{{ asset($novel->book_pic) }}" alt="{{ htmlspecialchars($novel->book_name) }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ htmlspecialchars($novel->book_name) }}</h5>
                                <p class="card-text">{{ Str::limit(htmlspecialchars($novel->book_description), 100) }}</p>
                                <p class="card-text"><small
                                        class="text-body-secondary">{{ htmlspecialchars($novel->User->name) }}</small></p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            {{ $books->links() }}
        @endif
    </div>
</div>
@endsection
