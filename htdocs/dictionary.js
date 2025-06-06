// --- サンプルの辞書データ ---
// 実際のアプリでは、このデータをAPIやデータベースから取得します。
const dictionaryData = [
    {
        word: "bonjour",
        pronunciation: "[bɔ̃ʒuʀ]",
        type: "間投詞",
        meaning: "こんにちは、おはよう"
    },
    {
        word: "merci",
        pronunciation: "[mɛʀsi]",
        type: "間投詞",
        meaning: "ありがとう"
    },
    {
        word: "chat",
        pronunciation: "[ʃa]",
        type: "男性名詞",
        meaning: "猫"
    },
    {
        word: "manger",
        pronunciation: "[mɑ̃ʒe]",
        type: "動詞",
        meaning: "食べる"
    },
    {
        word: "pomme",
        pronunciation: "[pɔm]",
        type: "女性名詞",
        meaning: "りんご"
    }
];

/**
 * 辞書データから単語を検索する関数
 * @param {string} term - 検索する単語
 * @returns {object|null} - 見つかった単語のオブジェクト、またはnull
 */
function searchWord(term) {
    if (!term) {
        return null;
    }
    const searchTerm = term.trim().toLowerCase();
    
    // 辞書データから検索語に一致する単語を探す (完全一致)
    const result = dictionaryData.find(entry => entry.word.toLowerCase() === searchTerm);

    return result || null; // 見つからない場合はnullを返す
}