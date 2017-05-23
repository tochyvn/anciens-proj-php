/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


  var
    element = document.getElementsByClassName("w8"),
    getPercent = function (x, total) {
      return (x * 100) / total;
    };

  window.addEventListener('load', function(){
    for (var i = 0, length = element.length; i < length; i++){

      element[i].addEventListener('mousedown', function(evt){
        if(getPercent(evt.offsetX, this.clientWidth) >= 70) {
          this.classList.add('w8-right');
        } else if(getPercent(evt.offsetX, this.clientWidth) <= 30) {
          this.classList.add('w8-left');
        }

        if(getPercent(evt.offsetY, this.clientHeight) >= 70) {
          this.classList.add('w8-bottom');
        } else if(getPercent(evt.offsetY, this.clientHeight) <= 30) {
          this.classList.add('w8-top');
        }

      });

      element[i].addEventListener('mouseup', function(){
        this.classList.remove('w8-left');
        this.classList.remove('w8-right');
        this.classList.remove('w8-top');
        this.classList.remove('w8-bottom');
      });

    }
  });