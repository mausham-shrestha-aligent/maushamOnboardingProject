function showCommentSection($id) {
    const style = document.getElementById($id).style.display;
    document.getElementById($id).style.display =
        style == 'none' ? 'block' : 'none';
}

function cancelCommentSection($id) {
    document.getElementById($id).style.display = 'none';
}