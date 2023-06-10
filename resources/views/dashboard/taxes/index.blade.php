@extends('layouts.dashboard.app')

 @push('css')
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Table styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th, table td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        table td a {
            color: #007bff;
            text-decoration: none;
        }

        table td a:hover {
            text-decoration: underline;
        }
    </style>
    @endpush

@section('content')
@include('dashboard.partials._errors')
    <h1>Taxes</h1>
    <button id="create-tax">Create Tax</button>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Rate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taxes as $tax)
                <tr>
                    <td>{{ $tax->name }}</td>
                    <td>{{ $tax->rate }}</td>
                    <td>
                        <a href="#" class="edit-tax" data-id="{{ $tax->id }}">Edit</a>
                        <form action="{{ route('dashboard.taxes.destroy', $tax->id)  }}" method="post" class="d-inline-block">
                            @csrf
                            @method('delete')
                            <button class="border-0 p-0 bg-white delete">
                                <span class="svg-icon svg-icon-2   svg-icon-danger ">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/>
                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/>
                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/>
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Create Tax Modal -->
    <div id="create-tax-modal" class="modal">
       
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create Tax</h2>
            <form method="POST" action="{{ route('dashboard.taxes.store') }}">
                @csrf
                <label for="name">Name:</label>
                <input type="text" name="name" id="name">

                <label for="rate">Rate:</label>
                <input type="number" name="rate" id="rate">

                <button type="submit">Create</button>
            </form>
        </div>
    </div>

    <!-- Edit Tax Modal -->
    <div id="edit-tax-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Tax</h2>
            <form id="edit-tax-form"  action="{{ route('dashboard.taxes.update','id') }}"  method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-tax-id">
                <label for="name">Name:</label>
                <input type="text" name="name" id="edit-tax-name">

                <label for="rate">Rate:</label>
                <input type="number" name="rate" id="edit-tax-rate">

                <button type="submit">Save</button>
            </form>
        </div>
    </div>
    


@push('js')
   
    <script>
        // Get the modal
        var createTaxModal = document.getElementById("create-tax-modal");
        var editTaxModal = document.getElementById("edit-tax-modal");

        // Get the button that opens the modal
        var createTaxBtn = document.getElementById("create-tax");

        // When the user clicks the button, open the modal
        createTaxBtn.onclick = function() {
            createTaxModal.style.display = "block";
        }

        // Get the <span> element that closes the modal
        var closeBtns = document.getElementsByClassName("close");

        // When the user clicks on <span> (x), close the modal
        for (var i = 0; i < closeBtns.length; i++) {
            closeBtns[i].onclick = function() {
                createTaxModal.style.display = "none";
                editTaxModal.style.display = "none";
            }
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == createTaxModal) {
                createTaxModal.style.display = "none";
            }
            if (event.target == editTaxModal) {
                editTaxModal.style.display = "none";
            }
        }

        // Edit Tax
        var editTaxBtns = document.getElementsByClassName("edit-tax");
        for (var i = 0; i < editTaxBtns.length; i++) {
            editTaxBtns[i].onclick = function() {
                var taxId = this.getAttribute("data-id");
                var taxName = this.parentNode.parentNode.childNodes[1].innerText;
                var taxRate = this.parentNode.parentNode.childNodes[3].innerText;

                document.getElementById("edit-tax-id").value = taxId;
                document.getElementById("edit-tax-name").value = taxName;
                document.getElementById("edit-tax-rate").value = taxRate;

                editTaxModal.style.display = "block";
            }
        }
    </script>
@endpush
@endsection