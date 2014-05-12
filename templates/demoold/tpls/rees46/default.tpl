<?php
$FORMS['view'] = <<<END

 <script type="text/javascript" src="//cdn.rees46.com/rees46_script2.js"></script>
        <script type="text/javascript" src="/js/rees46.js"></script>
        <script type="text/javascript">
            var reesReady = function() {

	            if('%type%' == 'object') {
                    REES46.pushData("view", {
                        "item_id": '%item_id%',
                        "category": '%category%',
                        "price": '%price%'
                    });
                }
                window.__REES46.push(REES46);

            }
        </script>
        <script type="text/javascript">
            REES46.init("%shop_id%", %user_id%, reesReady);
        </script>

END;

$FORMS['recommend'] = <<<END

		<h1>%header%</h1>

        <div id="recommender_%type%"></div>

        <script type="text/javascript">
            if (window.rees46_recommenders === undefined) {
            window.rees46_recommenders = []
            }
            window.rees46_recommenders.push('%type%')
        </script>


END;

?>