document.querySelectorAll('.reply-toggle').forEach(button => {
    button.addEventListener('click', () => {
      const postId = button.getAttribute('data-post-id');
      const replyForm = document.getElementById('reply-form-' + postId);
      replyForm.classList.toggle('hidden');
    });
});