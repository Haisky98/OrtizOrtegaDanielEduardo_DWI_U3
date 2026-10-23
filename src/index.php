<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php  
        include('template/head.php');
    ?>
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php  
                include('template/menu.php');
            ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_header" style="" class="header align-items-stretch">
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <?php  
                                include('template/header.php');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="post d-flex flex-column-fluid" id="principal">
                    <div id="kt_content_container" class="container-xxl">
                        <?php  
                            include('system/principal.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        include("template/footer.php");
    ?>
</body>
</html>