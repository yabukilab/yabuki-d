// ページが読み込まれたときに実行される処理
document.addEventListener('DOMContentLoaded', () => {

    // DOM要素を取得
    const queryDisplay = document.getElementById('search-query-display');
    const resultsContainer = document.getElementById('results-container');

    // 1. URLから検索キーワードを取得する
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('q'); // index.htmlの<input name="q">で設定した名前

    // 検索キーワードを表示
    if (query) {
        queryDisplay.innerHTML = `<h2>"<span>${escapeHTML(query)}</span>" の検索結果</h2>`;
    } else {
        queryDisplay.innerHTML = `<h2>検索キーワードが指定されていません</h2>`;
    }

    // 2. 辞書から単語を検索する (dictionary.jsの関数を呼び出す)
    const result = searchWord(query);

    // 3. 結果を表示する
    displayResult(result);

    function displayResult(resultData) {
        // 古い結果をクリア
        resultsContainer.innerHTML = '';

        if (resultData) {
            // 結果が見つかった場合、HTMLを生成して表示
            const resultHTML = `
                <div class="result-item">
                    <h3>${escapeHTML(resultData.word)}</h3>
                    <p class="pronunciation">${escapeHTML(resultData.pronunciation)}</p>
                    <p class="type">${escapeHTML(resultData.type)}</p>
                    <p class="meaning">${escapeHTML(resultData.meaning)}</p>
                </div>
            `;
            resultsContainer.innerHTML = resultHTML;
        } else {
            // 結果が見つからなかった場合
            resultsContainer.innerHTML = '<p class="not-found-message">単語が見つかりませんでした。</p>';
        }
    }

    // HTMLタグが入力された場合に無害化するためのヘルパー関数
    function escapeHTML(str) {
        return str.replace(/[&<>"']/g, function(match) {
            return {
                '&': '&',
                '<': '<',
                '>': '>',
                '"': '"',
                "'": ''
            :[match]:
        };;
    }
,);