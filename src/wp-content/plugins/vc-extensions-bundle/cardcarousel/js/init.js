jQuery(document).ready(function($) {
    "use strict";
    $('.cq-cardcarousel').each(function(index, el) {
        var _this = $(this);
        var _arrowcolor = $(this).data('arrowcolor');
        var _arrowbgcolor = $(this).data('arrowbgcolor');
        var _arrowhovercolor = $(this).data('arrowhovercolor');
        var _arrowbghovercolor = $(this).data('arrowbghovercolor');
        var _autodelay = parseInt($(this).data('autodelay'), 10) || 0;
        var _index = index;

        var _slideID = 0;
        function _autoDelaySlide(){
            _slideID = setInterval(function() {
                clearInterval(_slideID);
                _navigateCard(1);
                _autoDelaySlide();
            }, _autodelay*1000);
        }
        if(_autodelay > 0){
            _autoDelaySlide();
        }

        _this.on('mouseover', function(event) {
          if(_autodelay > 0){
            clearInterval(_slideID);
          }
        }).on('mouseleave', function(event) {
          if(_autodelay > 0){
            _autoDelaySlide();
          }
        });

        var _itemList = $(".cq-cardcarousel-list", _this);
        var _itemArr = [];
        var _itemNums = $('.cq-cardcarousel-item', _this).size();
        var _rotate = 360/_itemNums;
        _itemList[0].style.setProperty("--rotateDegrees", _rotate);
        $('.cq-cardcarousel-item', _this).each(function(index, el) {
            var _item = $(this);
            var _avatar = $('.cq-cardcarousel-avatar', _item);
            $(this).data('index', index);
            _itemArr.push($(this));

            if(_avatar.attr('title') != ""){
                var _tooltip = _avatar.tooltipster({
                    position: 'top',
                    delay: 200,
                    interactive: true,
                    speed: 300,
                    touchDevices: true,
                    animation: 'grow',
                    theme: 'tooltipster-shadow',
                    contentAsHTML: true
                });

            }
        });


        // $(document).on('lity:open', function(event, instance) {
        //     if(_autodelay > 0){
        //         clearInterval(_slideID);
        //     }
        // });
        // $(document).on('lity:remove', function(event, instance) {
        //     if(_autodelay > 0){
        //         _autoDelaySlide();
        //     }
        // });


        var _currentNum = 0;
        var _activeIndex = 0;
        function _navigateCard(n) {
            _currentNum += n;
            _itemList[0].style.setProperty('--currentCard', _currentNum);
            var _activeItem = $(".cq-cardcarousel-item.active", _this);
            if (_activeItem) _activeItem.removeClass("active");

            _activeIndex = (_activeIndex + n + _itemNums) % _itemNums;
            var _newActiveItem = _itemArr[_activeIndex];
            _newActiveItem.addClass('active');
        }

        _navigateCard(0);


        $('.cq-cardcarousel-prev', _this).on('click', function(event) {
            _navigateCard(-1);
            event.preventDefault();
        });
        $('.cq-cardcarousel-next', _this).on('click', function(event) {
            _navigateCard(1);
            event.preventDefault();
        });

        // var _timeout = 0;
        // $('.cq-cardcarousel-prev', _this).on('mousedown touchstart', function(event) {
        //     _timeout = setInterval(function(){
        //         _navigateCard(-1);
        //     }, 400);
        //     event.preventDefault();
        // }).on('mouseup mouseleave touchend', function(event) {
        //     clearInterval(_timeout);
        // });

        // $('.cq-cardcarousel-next', _this).on('mousedown touchstart', function(event) {
        //     _timeout = setInterval(function(){
        //         _navigateCard(1);
        //     }, 400);
        //     event.preventDefault();
        // }).on('mouseup mouseleave touchend', function(event) {
        //     clearInterval(_timeout);
        // });

        $('.cq-cardcarousel-next, .cq-cardcarousel-prev', _this).on('mouseover', function(event) {
            if(_arrowhovercolor != "") $(this).css('color', _arrowhovercolor);
            if(_arrowbghovercolor != "") $(this).css('background-color', _arrowbghovercolor);
        }).on('mouseleave', function(event) {
            if(_arrowcolor != "") $(this).css('color', _arrowcolor);
            if(_arrowbgcolor != "") $(this).css('background-color', _arrowbgcolor);
        });


    });
});
