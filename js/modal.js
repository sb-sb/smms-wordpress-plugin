window.onload = function () {
    // 获取需要使用到的元素
    var toggleModal = document.getElementById("toggleModal");
    var mask = document.getElementsByClassName("mask")[0];
    var modal = document.getElementsByClassName("modal")[0];
    var closes = document.getElementsByClassName("close");
    toggleModal.onclick = show;
    closes[0].onclick = close;
    closes[1].onclick = close;
    function show() {
        mask.style.display = "block";
        modal.style.display = "block";
    }
    function close() {
        mask.style.display = "none";
        modal.style.display = "none";
    }

}