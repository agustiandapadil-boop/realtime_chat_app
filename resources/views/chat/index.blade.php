<x-app-layout>
<div class="flex h-screen bg-gray-100">
<div class="w-1/4 bg-white border-r flex flex-col">
<div class="p-4 border-b flex justify-between items-center">
    <h2 class="text-xl font-bold">TindaraChat</h2>
    <button
        onclick="openGroupModal()"
        class="bg-purple-500 text-white px-3 py-1 rounded-lg">Buat Grup</button>
</div>

<div class="p-4 border-b">
    <input
        type="text"
        id="search-user"
        placeholder="Search user..."
        class="w-full border rounded-lg px-4 py-2">
</div>
<div id="user-list" class="flex-1 overflow-y-auto">

@foreach($users as $user)
<div
    onclick="selectUser({{ $user->id }},'{{ $user->name }}')"
    class="user-item p-4 border-b hover:bg-gray-100 cursor-pointer flex justify-between items-center"
    data-name="{{ strtolower($user->name) }}">
<div>

<div class="font-semibold">
{{ $user->name }}
</div>

<div
    id="status-{{ $user->id }}"
    class="text-sm {{ $user->is_online ? 'text-green-500' : 'text-red-500' }}">
● {{ $user->is_online ? 'Online' : 'Offline' }}
</div>
</div>
</div>
@endforeach

</div>
<div class="border-t">
<div class="p-4 font-bold">Grup Chat</div>

@foreach($groups as $group)

<div class="p-4 border-b hover:bg-gray-100 flex justify-between items-center">

<div
    onclick="selectGroup({{ $group->id }},'{{ $group->name }}')"
    class="cursor-pointer flex-1">
{{ $group->name }}
</div>

<button
    onclick="leaveGroup({{ $group->id }})"
    class="text-xs text-red-500 hover:text-red-700 font-bold px-2 py-1 border border-red-500 rounded ml-2">Keluar</button>
</div>

@endforeach
</div>
</div>
<div class="w-3/4 flex flex-col">
<div class="bg-white p-4 border-b">
    <h2 id="chat-title" class="text-xl font-bold">Pilih Chat</h2>
</div>

<div
    id="messages"
    class="flex-1 overflow-y-auto p-4 space-y-2">
</div>

<div
    id="chat-input-area"
    class="hidden bg-white p-4 border-t">
<form id="chat-form">

@csrf
<div class="flex gap-2">
<input
    type="text"
    id="message"
    class="w-full border rounded-lg px-4 py-2"
    placeholder="Type message...">
<button
    type="submit"
    class="bg-purple-500 text-white px-6 rounded-lg">Kirim</button>

</div>
</form>
</div>
</div>
</div>
<div
    id="group-modal"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">

<div class="bg-white p-6 rounded-lg w-96">
    <h2 class="text-xl font-bold mb-4">Buat Grup</h2>

<input
    type="text"
    id="group-name"
    placeholder="Nama Group"
    class="w-full border rounded-lg px-4 py-2 mb-4">
<div class="max-h-48 overflow-y-auto mb-4">

@foreach($users as $user)
<label class="block mb-2">
<input
    type="checkbox"
    value="{{ $user->id }}"
    class="group-member">

{{ $user->name }}
</label>
@endforeach
</div>
<div class="flex gap-2">
<button
    onclick="createGroup()"
    class="bg-purple-500 text-white px-4 py-2 rounded-lg">
Buat
</button>
<button
    onclick="closeGroupModal()"
    class="bg-red-500 text-white px-4 py-2 rounded-lg">batal</button>

</div>
</div>
</div>
<script type="module">

let selectedUser=null;
let selectedGroup=null;

document.getElementById('search-user')
.addEventListener('keyup',function(){
    let value=this.value.toLowerCase();
    let users=document.querySelectorAll('.user-item');

users.forEach((user)=>{
    let name=user.dataset.name;
    if(name.includes(value)){
        user.style.display='flex';
    }
    else{
        user.style.display='none';
    }
});
});

window.selectUser=async function(id,name){
    selectedUser=id;
    selectedGroup=null;

document.getElementById('chat-title').innerText=name;
document.getElementById('messages').innerHTML='';
document.getElementById('chat-input-area')
    .classList.remove('hidden');
    let response=await fetch('/chat/private/'+id);
    let data=await response.json();
if(data.success){
data.messages.forEach((msg)=>{
    appendMessage(
        msg.message,
        msg.sender_id=={{ auth()->id() }},
        msg.sender.name
);
});
}
}

window.selectGroup=async function(id,name){
    selectedGroup=id;
    selectedUser=null;
    document.getElementById('chat-title').innerText=' '+name;
    document.getElementById('messages').innerHTML='';
    document.getElementById('chat-input-area')
    .classList.remove('hidden');
let response=await fetch('/chat/group/'+id);
let data=await response.json();
    if(data.success){
data.messages.forEach((msg)=>{
    appendMessage(
        msg.message,
        msg.sender_id=={{ auth()->id() }},
        msg.sender.name
);
});
}
}

function appendMessage(message,mine=false,sender=''){
    let messages=document.getElementById('messages');
    messages.innerHTML+=`
<div class="flex ${mine?'justify-end':'justify-start'}">
    <div class="px-4 py-2 rounded-lg max-w-xs ${mine?'bg-purple-500 text-white':'bg-gray-300'}">
        ${!mine?`<div class="font-bold mb-1">${sender}</div>`:''}
        ${message}
</div>
</div>
`;
    messages.scrollTop=messages.scrollHeight;
}
document.getElementById('chat-form')
.addEventListener('submit',async function(e){
    e.preventDefault();
let messageInput=document.getElementById('message');
let message=messageInput.value;
    if(message.trim()==''){
        return;
    }
    if(selectedUser){
let response=await fetch('/send-message',{
method:'POST',
    headers:{
        'Content-Type':'application/json',
        'Accept':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
},
body:JSON.stringify({
    receiver_id:selectedUser,
    message:message
})
});

let data=await response.json();
    if(!response.ok || !data.success){
        alert('Error');
        return;
}
        appendMessage(data.message.message,true);
}
else if(selectedGroup){
let response=await fetch('/send-group-message',{
    method:'POST',
    headers:{
        'Content-Type':'application/json',
        'Accept':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
},
body:JSON.stringify({
    group_id:selectedGroup,
    message:message
})
});
let data=await response.json();
    if(!response.ok || !data.success){
    alert('Error');
        return;
}
appendMessage(data.message.message,true);
}
else{
    alert('Pilih chat dulu');
    return;
}
    messageInput.value='';
});

if(typeof window.Echo!=='undefined'){
window.Echo.private('chat.{{ auth()->id() }}')
.listen('.message.sent',(e)=>{
    if(selectedUser==e.sender_id){
    appendMessage(
        e.message,
        false,
        e.sender
);
}
});
@foreach($groups as $group)
window.Echo.private('group.{{ $group->id }}')
.listen('.message.sent',(e)=>{
    if(selectedGroup==e.group_id){
    if(e.sender_id!={{ auth()->id() }}){
    appendMessage(
        e.message,
        false,
        e.sender
);
}
}
});

@endforeach
window.Echo.join('online')
.here((users)=>{
users.forEach((user)=>{
let status=document.getElementById('status-'+user.id);
    if(status){
    status.innerHTML='● Online';
    status.classList.remove('text-red-500');
    status.classList.add('text-green-500');
}
});
})

.joining((user)=>{
let status=document.getElementById('status-'+user.id);
    if(status){
    status.innerHTML='● Online';
        status.classList.remove('text-red-500');
        status.classList.add('text-green-500');
}
})
.leaving((user)=>{
let status=document.getElementById('status-'+user.id);
    if(status){
    status.innerHTML='● Offline';
        status.classList.remove('text-green-500');
        status.classList.add('text-red-500');
    }
});
}
window.openGroupModal=function(){
    document.getElementById('group-modal')
    .classList.remove('hidden');
}
window.closeGroupModal=function(){
    document.getElementById('group-modal')
    .classList.add('hidden');
}
window.leaveGroup=async function(id){
    if(!confirm('Keluar dari grup?')){
        return;
    }
let response=await fetch('/groups/'+id+'/leave',{
    method:'DELETE',
headers:{
    'Content-Type':'application/json',
    'Accept':'application/json',
    'X-CSRF-TOKEN':'{{ csrf_token() }}'
}
});
let data=await response.json();
    if(data.success){
        alert('Berhasil keluar grup');
        location.reload();
    }
}
window.createGroup=async function(){
let name=document.getElementById('group-name').value;
let members=[];
    document.querySelectorAll('.group-member:checked')
    .forEach((checkbox)=>{
        members.push(checkbox.value);
    });
let response=await fetch('/groups',{
    method:'POST',
    headers:{
        'Content-Type':'application/json',
        'Accept':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
},
    body:JSON.stringify({
        name:name,
        members:members
})
    });
let data=await response.json();
if(data.success){
    alert('Group berhasil dibuat');
    location.reload();
    }
}
</script>
</x-app-layout>
