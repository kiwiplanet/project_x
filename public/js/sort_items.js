    
    "use strict";

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

        // window.location.href = http://127.0.0.1:8000/items/result ?_token=qke8c0tASiiJBUTp6iPYBax3kbZYHwSMwoYh633J&keyword=&seasons%5B%5D=1&seasons%5B%5D=5&sort=mostStock
        const url = new URL(window.location.href);

        // url.search = _token=qke8c0tASiiJBUTp6iPYBax3kbZYHwSMwoYh633J&keyword=&seasons%5B%5D=1&seasons%5B%5D=5&sort=mostStock
        let params = new URLSearchParams(url.search);
        
        switch(selectedOption) {
            case 'newest':
                params.set("sort","newest")
                break;
            case 'oldest':
                params.set("sort","oldest")
                break;
            case 'mostStock':
                params.set("sort","mostStock")
                break;
            case 'leastStock':
                params.set("sort","leastStock")
                break;
            default:
                window.location.href = '';
                break;
        }
        let currentURL = window.location.href
        let newURL = currentURL.split("?")[0]
        window.location.href = newURL + "?" + params.toString()
    });