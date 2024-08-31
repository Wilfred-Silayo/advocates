@extends('layout.app')
@section('title', 'Chats')
@section('content')
<div class="container">
    <div class="row mt-4">
        <!-- Search Section for Large Screens (Admin only) -->
        @if(auth()->user()->role !== 'user')
        <div class="d-none d-md-block col-md-5 search-container">
            <div class="card h-100">
                <div class="card-header">
                    <input type="search" name="user" placeholder="Search users" id="search-user" class="form-control" style="border: 2px solid blue;" autofocus>
                </div>
                <div class="card-body" id="search-results">
                    <!-- Search results will be appended here -->
                </div>
            </div>
        </div>
        @endif

        <!-- Mobile Search Button for Admin -->
        @if(auth()->user()->role !== 'user')
        <div class="col d-md-none">
            <a href="#" class="btn btn-outline-primary mb-3" data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas" aria-controls="searchOffcanvas">Search users</a>
        </div>
        @endif

        <!-- Chat Section -->
        <div class="col-12 col-md-7 chat-container">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between" id="chat-header">
                    <!-- Dynamic User Profile and Name will be displayed here -->
                    <span id="chat-user-name">
                        @if(auth()->user()->role == 'user')
                        Chating with Admin...
                        @else
                        Select a user to start chat
                        @endif
                    </span>
                    <span class="text-end pe-1 {{Auth()->user()->role=='user' ? 'd-block': 'd-md-none' }}">
                        <i class="fas fa-trash text-danger cursor-pointer p-1 delete-icon"
                            data-id="{{$superuser->id}}" title="Delete conversation"></i>
                    </span>
                </div>
                <div class="card-body overflow-auto" id="chat-area">
                    <!-- Chats will be displayed here -->
                </div>
                <div class="card-footer">
                    <form id="message-form" method="POST">
                        @csrf
                        <input id="receiver_hidden" type="hidden" name="receiver_id" value="{{$superuser->id}}">
                        <textarea id="message-text" name="message" class="form-control" placeholder="Type your message..."></textarea>
                        <!-- <input type="file" id="attachment" multiple> -->
                        <button type="submit" class="btn btn-primary mt-2">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Search Offcanvas -->
<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="searchOffcanvas" aria-labelledby="searchOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 id="searchOffcanvasLabel">Search Users</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <input type="search" name="user" id="search-user-offcanvas" class="form-control" style="border: 2px solid blue;" autofocus>
        <div id="search-results-offcanvas" class="mt-2">
            <!-- Search results will be appended here -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete all conversations with this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        const userRole = "{{ auth()->user()->role }}";
        const superUserId = "{{ $superuser->id }}";
        const currentUserId = '{{ Auth::id() }}';

        // Function to handle search user
        function searchUsers(query) {
            $.ajax({
                url: '/search-users',
                method: 'GET',
                data: {
                    query: query
                },
                success: function(data) {
                    $('#search-results, #search-results-offcanvas').empty();
                    data.forEach(function(user) {
                        const badge = user.unread_count > 0 ? `<span class="badge bg-danger">${user.unread_count}</span>` : '';
                        $('#search-results, #search-results-offcanvas').append(`
                        <div class="user-item" data-id="${user.id}" data-name="${user.name}">
                            <div class="row">
                                <div class="col-2">
                                    <img width="30" src="/storage/profile_images/${user.profile_pic}" alt="${user.name} Profile Picture" class="img-fluid rounded-circle">
                                </div>
                                <div class="col-7 text-break">${user.name}</div>
                                <div class="col-2">${badge}</div>
                                <div class="col-1">
                                    <i class="fas fa-trash text-danger p-1 delete-icon" data-id="${user.id}" title="Delete conversation"></i>
                                </div>
                            </div>
                        </div>
                    `);
                    });
                },
                error: function() {
                    alert('Error searching users.');
                }
            });
        }

        function loadRecentChats() {
            $.ajax({
                url: '/recent-chats',
                method: 'GET',
                success: function(data) {
                    $('#search-results').empty();
                    data.forEach(function(user) {
                        const badge = user.unread_count > 0 ? `<span class="badge bg-danger">${user.unread_count}</span>` : '';
                        $('#search-results').append(`
                        <div class="user-item" data-id="${user.id}" data-name="${user.name}">
                            <div class="row">
                                <div class="col-2">
                                    <img width="30" src="/storage/profile_images/${user.profile_pic}" alt="${user.name} Profile Picture" class="img-fluid rounded-circle">
                                </div>
                                <div class="col-7 text-break">${user.name}</div>
                                <div class="col-2">${badge}</div>
                                <div class="col-1">
                                    <i class="fas fa-trash text-danger p-1 delete-icon" data-id="${user.id}" title="Delete conversation"></i>
                                </div>
                            </div>
                        </div>
                    `);
                    });
                },
                error: function() {
                    // alert('Error loading recent chats.');
                }
            });
        }

        function loadConversation(userId) {
            $.ajax({
                url: '/load-conversation/' + userId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let chatArea = $('#chat-area');
                    chatArea.empty();
                    data.messages.forEach(function(message) {
                        let messageHtml = `
                        <div class="message p-2 rounded col-8 ${message.sender_id === currentUserId ? 'sent' : 'received'}">
                            <p>${message.message}</p>
                            <small>${new Date(message.created_at).toLocaleString()}</small>
                        </div>
                    `;
                        chatArea.append(messageHtml);
                    });

                    chatArea.scrollTop(chatArea[0].scrollHeight); // Scroll to bottom of chat area
                },
                error: function(xhr, status, error) {
                    console.log('Error details:', xhr, status, error);
                }
            });
        }

        function fetchNewMessages() {
            $.ajax({
                url: '/fetch-new-messages',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    data.badges.forEach(function(badge) {
                        $(`.user-item[data-id="${badge.user_id}"] .badge`).text(badge.unread_count);
                    });

                    if ($('#chat-user-name').text() !== 'Select a user to start chat') {
                        let currentUserId = $(`#receiver_hidden`).val();
                        if (currentUserId) {
                            loadConversation(currentUserId);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error details:', xhr, status, error);
                }
            });
        }

        setInterval(fetchNewMessages, 3000);
        // setInterval(loadRecentChats, 3000);

        $(document).on('click', '.user-item', function() {
            const receiverId = $(this).data('id');
            $('#chat-user-name').text($(this).data('name'));
            $('#receiver_hidden').val(receiverId);
            $('#searchOffcanvas').offcanvas('hide');
            loadConversation(receiverId);
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#search-user, #search-user-offcanvas').on('input', function() {
            const query = $(this).val();
            if (query.length > 0) {
                searchUsers(query);
            } else {
                $('#search-results, #search-results-offcanvas').empty();
            }
        });

        $('#message-form').on('submit', function(event) {
            event.preventDefault();

            const formData = $(this).serialize();
            const receiverId = $('#receiver_hidden').val();
            const message = $('#message-text').val();

            if (!receiverId || !message.trim()) {
                alert('Please enter a message to send.');
                return;
            }
            if (receiverId == currentUserId) {
                alert('Please select a user to start chat.');
                return;
            }

            $.ajax({
                url: '/send-message',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#message-text').val('');
                    loadConversation(receiverId);
                },
                error: function(xhr, status, error) {
                    alert('Error sending message.');
                    console.log('Error details:', xhr.responseText);
                }
            });
        });

        let receiverIdToDelete;

        // Handle the click on the delete icon to show the modal
        $(document).on('click', '.delete-icon', function() {
            if (userRole == 'user') {
                receiverIdToDelete = $('#receiver_hidden').val();
            }
            else if($('#receiver_hidden').val() == superUserId && userRole != 'admin') {
                alert('Please select user conversation.');
                return;
            }
            else{
                receiverIdToDelete = $(this).data('id');
            }
           
  
            $('#deleteModal').modal('show');
        });

        $('#confirm-delete').on('click', function() {
            if (receiverIdToDelete) {
                deleteConversation(receiverIdToDelete);
            }
        });

        function deleteConversation(receiverId) {
            $.ajax({
                url: '/delete-conversation',
                method: 'POST',
                data: {
                    receiver_id: receiverId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $(`.user-item[data-id="${receiverId}"]`).remove(); 
                        $('#chat-area').empty(); 
                        $('#chat-user-name').text('Select a user to start chat'); 
                        $('#deleteModal').modal('hide');
                    } else {
                        alert('Error deleting conversation.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error deleting conversation.');
                    console.log('Error details:', xhr, status, error);
                }
            });
        }



        if (userRole !== 'user') {
            loadRecentChats();
        } else {
            const receiverId = $('#receiver_hidden').val();
            if (receiverId) {
                loadConversation(receiverId);
            }
        }
    });
</script>
@endsection