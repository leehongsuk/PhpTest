    var fnToolbar =
    {
            toolbar: {
                target: new AXToolBar(),
                init: function(){
                    var menu =
                    [
                        {
                            label   : "극장관리", addClass: "",
                            onclick : function (menu, event) {
                                trace("1", menu);
                            },
                            menu    : [
                                {
                                    label: "극장정보", onclick: function (event) {}
                                }
                            ],
                            filter: function(){
                                return true;
                            }
                        },
                        {
                            label   : "영화관리", addClass: "",
                            onclick : false,
                            menu    : [
                                {
                                    label: "영화정보", onclick: function (event) {}
                                },
                                {
                                    label: "프린트정보", onclick: function (event) {}
                                }
                            ]
                        },
                        {
                            label   : "스코어관리", addClass: "",
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
