    
    "use strict";

    // このファイルは並び替え機能を実装するためのものです

    // ページのDOMが完全に読み込まれたときに実行される処理
    document.addEventListener("DOMContentLoaded", function() {
        // セレクト要素を取得
        var sortOptions = document.getElementById('sortOptions');
        // 現在のページのURLからクエリパラメーターを取得
        var urlParams = new URLSearchParams(window.location.search);
        // 'sort' パラメーターの値を取得
        var sortParam = urlParams.get('sort');
        
        // 'sort' パラメーターが存在する場合
        if (sortParam !== null) {
            // セレクト要素の選択肢を 'sort' パラメーターの値に設定
            sortOptions.value = sortParam;
        }
    });

    document.getElementById('sortOptions').addEventListener('change', function() {
        var selectedOption = this.value;
        
        switch(selectedOption) {
            case 'newest':
                window.location.href = '?sort=newest';
                break;
            case 'oldest':
                window.location.href = '?sort=oldest';
                break;
            case 'mostStock':
                window.location.href = '?sort=mostStock';
                break;
            case 'leastStock':
            window.location.href = '?sort=leastStock';
                break;
            default:
                window.location.href = '';
                break;
        }
    });