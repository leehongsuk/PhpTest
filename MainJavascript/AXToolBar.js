    var fnToolbar =
    {
            toolbar: {
                target: new AXToolBar(),
                init: function(){
                    var menu =
                    [
                        {
                            label   : "극장관리", 
                            addClass: "",
                            onclick : false,
                            menu    : [
                                {
                                    label: "극장정보",
                                    gotoUrl : "./TheaterList.php",
                                    onclick: function (event) { location.href = this.menu.gotoUrl ; }
                                }
                            ],
                            filter: function(){
                                return true;
                            }
                        },
                        {
                            label   : "영화관리", 
                            addClass: "",
                            onclick : false,
                            menu    : [
                                {
                                    label: "영화정보", 
                                    gotoUrl : "./FilmList.php",
                                    onclick: function (event) { location.href = this.menu.gotoUrl ; }
                                },
                                {
                                    label: "기본부율", 
                                    gotoUrl : "./PremiumRate.php",
                                    onclick: function (event) { location.href = this.menu.gotoUrl ; }
                                }
                            ]
                        },
                        {
                            label   : "스코어관리", 
                            addClass: "",
                            onclick : false,
                            menu    : [
                                {
                                    label: "스코어입력", onclick: function (event) {}
                                }
                            ]
                        }
                    ];


                    var type = 1;
                    this.target.setConfig(
                    {
                        targetID: "tool-bar",
                        theme   : "AXToolBar",
                        menu    : menu,
                        filter  : function(){
                            return this.menu.type != type;
                        },
                        reserveKeys: {
                            subMenu: "menu"
                        }
                    });

                }
            }
    }
