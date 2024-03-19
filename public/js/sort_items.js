// 選択したセレクトボックスの値で画面をソート

document.getElementById('sortSelect').addEventListener('change', function() {
    var sortBy = this.value;
    var form = document.getElementById('sortForm');
    var sortInput = document.createElement('input');
    sortInput.setAttribute('type', 'hidden');
    sortInput.setAttribute('name', 'sort');
    sortInput.setAttribute('value', sortBy);
    form.appendChild(sortInput);
    form.submit();
});

