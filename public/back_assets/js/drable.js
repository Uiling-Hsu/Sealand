/*
         * HTML Drag and Drop API（拖、放操作 API）
         */
var dragged;  // 保存拖動元素的引用（ref.），就是拖動元素本身

// 當開始拖動一個元素或一個選擇文本的時候 dragstart 事件就會觸發（設定拖動資料和拖動用的影像，且當從 OS 拖動檔案進入瀏覽器時不會觸發）
document.addEventListener('dragstart', function(event) {
    dragged = event.target;
    event.target.style.backgroundColor = 'rgba(240, 240, 240, 0.5)';
    event.target.style.color = 'rgba(0, 0, 0, 0.5)';
}, false);

// 不論結果如何，拖動作業結束當下，被拖動元素都會收到一個 dragend 事件（當從 OS 拖動檔案進入瀏覽器時不會觸發）
document.addEventListener('dragend', function(event) {
    // 重置樣式
    event.target.style.backgroundColor = 'white';
    event.target.style.color = '#000';
}, false);

// 當一個元素或者文本被拖動到有效放置目標 dragover 事件就會一直觸發（每隔幾百毫秒）
// 絕大多數的元素預設事件都不准丟放資料，所以想要丟放資料到元素上，就必須取消預設事件行為
// 取消預設事件行為能夠藉由呼叫 event.preventDefault 方法
document.addEventListener('dragover', function(event) {
    // 阻止預設事件行為
    event.preventDefault();
}, false);

// 當拖動的元素或者文本進入一個有效的放置目標 dragenter 事件就會觸發
document.addEventListener('dragenter', function(event) {
    // 當拖動的元素進入可放置的目標（自訂符合條件），變更背景顏色
    // 自訂條件：class 名稱 && 不是本身的元素
    if (event.target.parentNode.className == 'data' &&
        dragged !== event.target.parentNode) {
        dragged.style.background = 'grey';

        // 判斷向下或向上拖動，來決定在元素前或後插入元素
        if (dragged.rowIndex < event.target.parentNode.rowIndex) {
            event.target.parentNode.parentNode.insertBefore(dragged, event.target.parentNode.nextSibling);
        }
        else {
            event.target.parentNode.parentNode.insertBefore(dragged, event.target.parentNode);
        }
    }
}, false);

// 當拖動的元素或者文本離開有效的放置目標 dragleave 事件就會觸發
document.addEventListener('dragleave', function(event) {
    // 當拖動元素離開可放置目標節點，重置背景
    // 自訂條件：class 名稱 && 不是本身的元素
    if (event.target.parentNode.className == 'data' &&
        dragged !== event.target.parentNode) {
        // 當拖動元素離開可放置目標節點，重置背景
        event.target.parentNode.style.background = '';
    }
}, false);

function paddingLeft(num, length) {
    for(var len = (num + "").length; len < length; len = num.length) {
        num = "0" + num;
    }
    return num;
}


