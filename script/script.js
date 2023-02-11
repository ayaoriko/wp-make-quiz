(function() {
  const quizWrappers = document.querySelectorAll('.wp-make-quiz');
   /**回答をクリックしたら**/
  quizWrappers.forEach(function(quizWrapper) {
    const quizQuestionLis = quizWrapper.querySelectorAll('.wp-make-quiz-question-list');
    quizQuestionLis.forEach(function(quizQuestionLi) {
      quizQuestionLi.addEventListener('click', function() {
        if (quizWrapper.classList.contains('open')) {
          return false;
        }

        quizWrapper.classList.add('open');
        quizQuestionLis.forEach(function(li) {
          li.classList.add('disabled');
        });

        quizQuestionLi.classList.add('choice');

        if (quizQuestionLi.classList.contains('correct')) {
          //正解
          quizWrapper.querySelector('.wp-make-quiz-result.correct').classList.add('show');
        } else {
          //不正解
          quizWrapper.querySelector('.wp-make-quiz-result.incorrect').classList.add('show');
        }

        const quizSelector = quizWrapper.querySelector('.wp-make-quiz-answer')
        quizSelector.style.display = 'block';

        // 問題に戻るボタン
        const continueButton = quizWrapper.querySelector('.wp-make-quiz-continue');
        continueButton.addEventListener('click', function() {
          quizSelector.style.display = 'none';

          const quizWrapper = this.closest('.wp-make-quiz');
          quizWrapper.classList.remove('open');

          const questionResultItems = quizWrapper.querySelectorAll('.wp-make-quiz-result');

          questionResultItems.forEach(function(listItem) {
            listItem.classList.remove('show');
          });

          const questionListItems = quizWrapper.querySelectorAll('.wp-make-quiz-question-list');

          questionListItems.forEach(function(listItem) {
            listItem.classList.remove('disabled');
            listItem.classList.remove('choice');
          });
        });
      });
    });
  });
})();
