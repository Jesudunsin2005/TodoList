<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .parent-container {
            box-sizing: content-box;
            background-color: orange;
            height: 60vh;
            border-radius: 20px;
            width: 85vh;
            display: flex;
            justify-content: center;
            align-content: center;
        }
        .box-container {
            background-color: green;
            width: 80vh;
            height: 55vh;
            align-self: center;
            border-radius: 20px;
            align-items: center;
            padding: 12px;
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 50px;
            overflow-y: scroll;
        }

        .box-container::-webkit-scrollbar {
            display: none;
        }

        .child-one {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .add {
            display: flex;
            gap: 5px;
        }
        .input-first {
            width: 450px;
            height: 30px;
            border: 2px solid black;
            border-radius: 15px;
            padding: 10px;
        }
        button {
            width: 100px;
            height: 55px;
            border: 2px solid black;
            border-radius: 8px;
        }
        .add-form {
            border: 2px solid orange;
            display: flex;
            width: 70vh;
            border-radius: 20px;
            padding: 9px;
            align-items: center;
            justify-content: left;
            gap: 20px;
        }
        .grand-one {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .content {
            align-self: center;
        }
        .delete {
            border: 1px solid red;
            color: red;
        }

        .modal {
            display: none; 
            position: fixed; 
            z-index: 100; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: orange; 
            padding: 20px;
            border-radius: 10px;
            width: 60vh;
            height: 40vh;
            text-align: center;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            background-color: red;
            color: white;
            width: fit-content;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            height: fit-content;
            cursor: pointer;
        }
        .modal-content, .form-update{
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        .update-button{
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="parent-container">
        <div class="box-container">
            <div class="child-one">
                <h1>Create your Todo-List</h1>
                <form action="{{ route('store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="add">
                        <input class="input-first" type="text" name="content" placeholder="What are your tasks for today?">
                        <button type="submit">Add</button>
                    </div>
                </form>
            </div>
            <div class="child-two">
                <div class="grand-one">
                    @if(count($todolists))
                    @foreach($todolists as $todolist)
                        <div class="add-form">
                            <form action="{{ route('status', $todolist -> id) }}" class="sub-check" method="POST">
                                @csrf
                                <input type="checkbox" name="status" class="status" {{ $todolist->is_completed == 1 ? 'checked' : ''   }}>
                                <button style="display: none;" class="sub-status"></button>
                            </form>
                            <div class="content">{{$todolist -> content }}</div>
                            <form action="{{ route('destroy', $todolist -> id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="delete">DELETE</button>
                            </form>
                            <button onclick="openModal({{ $todolist->id }})" class="edit">EDIT</button>
                        </div>
                    @endforeach
                    @else
                        <p class="no-task">No Tasks!</p>
                    @endif
                </div>
            </div>
            @if($pendingTasks = $todolists->where('is_completed', 0)->count())
                <div>You have {{ $pendingTasks }} pending tasks</div>
            @else
                <div>You have no pending tasks</div>
            @endif
        </div>
    </div>

    <div id="myModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeModal()">X</button>
        <h2>Edit Task</h2>

        <form id="editForm" class="form-update" method="POST" >
            @csrf
            <div class="form-group">
                <label for="name">Todo Name</label>
                <input type="text" name="content" id="modal-content-input" value="" class="form-control">
            </div>

            <button type="submit" class="update-button">Update Task</button>
        </form>
    </div>
</div>


    <script>
        document.querySelectorAll(".status").forEach((checkbox) => {
            checkbox.addEventListener("click", function() {
                const form = this.closest('form');
                const submitButton = form.querySelector(".sub-status");

                if (submitButton) {
                    submitButton.click();
                }
            });
        });

        function openModal(id) {
            document.getElementById("myModal").style.display = "flex";
            document.getElementById("editForm").setAttribute("action",  "/todolists/" + id )
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Close the modal if user clicks outside of the modal content
        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
