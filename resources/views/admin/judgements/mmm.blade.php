<?php
	$conn = mysqli_connect("localhost", "root", "", "blog_samples");
	$keyword = "";
	$queryCondition = "";
	if(!empty($_POST["keyword"])) {
		$keyword = $_POST["keyword"];
		$wordsAry = explode(" ", $keyword);
		$wordsCount = count($wordsAry);
		$queryCondition = " WHERE ";
		for($i=0;$i<$wordsCount;$i++) {
			$queryCondition .= "title LIKE '%" . $wordsAry[$i] . "%' OR description LIKE '%" . $wordsAry[$i] . "%'";
			if($i!=$wordsCount-1) {
				$queryCondition .= " OR ";
			}
		}
	}
	$orderby = " ORDER BY id desc";
	$sql = "SELECT * FROM links " . $queryCondition;
	$result = mysqli_query($conn,$sql);
?>
<?php
	function highlightKeywords($text, $keyword) {
		$wordsAry = explode(" ", $keyword);
		$wordsCount = count($wordsAry);

		for($i=0;$i<$wordsCount;$i++) {
			$highlighted_text = "<span style='font-weight:bold;'>$wordsAry[$i]</span>";
			$text = str_ireplace($wordsAry[$i], $highlighted_text, $text);
		}

		return $text;
	}
?>
<html>
	<head>
	<title>Highlighting Keywords in Search Results with PHP</title>
	<style>
		body{
			width: 600px;
			font-family: "Segoe UI",Optima,Helvetica,Arial,sans-serif;
			line-height: 25px;
		}
		.search-box {
			padding: 30px;
			background-color: #C0FBDA;
			border-radius: 5px;
		}
		.search-label{
			margin:2px;
		}
		.demoInputBox {
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin: 0px 5px 15px;
			width: 250px;
		}
		.btnSearch{
			padding: 10px;
			background: #8A8A8A;
			border: 0;
			border-radius: 4px;
			margin: 0px 5px;
			color: #FFF;
			width: 150px;
		}
		.result-title {
			color: #AA00FF;
		}
		.result-description{
			margin: 5px 0px 15px;
		}
	</style>
	</head>
	<body>
		<h2>Highlighting Keywords in Search Results with PHP</h2>
    <div>
			<form name="frmSearch" method="post" action="">
                <div class="search-box">
                    <label class="search-label">Enter Search Keyword:</label>
                    <div>
                        <input type="text" name="keyword" class="demoInputBox" value="<?php echo $keyword; ?>"	/>
                    </div>
                    <div>
                        <input type="submit" name="go" class="btnSearch" value="Search">
                    </div>
                </div>
            </form>
			<?php
				while($row = mysqli_fetch_assoc($result)) {
				$new_title = $row["title"];
				if(!empty($_POST["keyword"])) {
					$new_title = highlightKeywords($row["title"],$_POST["keyword"]);
				}
				$new_description = $row["description"];
				if(!empty($_POST["keyword"])) {
					$new_description = highlightKeywords($row["description"],$_POST["keyword"]);
				}
			?>
			<div>
				<div class="result-title"><?php echo $new_title; ?></div>
				<div class="result-description"><?php echo $new_description; ?></div>
			</div>
			<?php } ?>
		</div>
	</body>
</html>



<div class="container-fluid">
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <i class="mdi mdi-message mr-2 text-green-0"></i><strong>Welcome back {{Str::words(Auth::user()->name, 1, '')}}</strong> You can now access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="row">
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/judgements')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Judgements
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt=" Latest Judgments">
                                    {{-- <span class="text-4xl">{{number_format($judgement_count)}}</span> <span class="text-muted">Cases</span> --}}
                                    <span class="text-4xl">7,930</span> <span class="text-muted">Cases</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/laws-of-federation')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-3">
                            Laws
                            </h6>
                            <span class="h2 mb-0">
                                <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Laws of Federation">
                                <span class="text-4xl">{{number_format($fed_count)}}</span> <span class="text-muted">Laws</span>
                            </span>
                        </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/rules-of-court')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                Rules
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="State Rules of Court">
                                    <span class="text-4xl">{{number_format($rule_count)}}</span> <span class="text-muted">Rules</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/forms-and-precedents')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-3">
                                Forms
                            </h6>
                            <span class="h2 mb-0">
                                <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt="Forms & Precedences">
                                <span class="text-4xl">{{number_format($form_count)}}</span> <span class="text-muted">Forms</span>
                            </span>
                        </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/legal-articles')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Legal Articles
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt="Legal Articles">
                                    <span class="text-4xl">{{number_format($article_count)}}</span> <span class="text-muted">Articles</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/laws-of-federation')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-3">
                            Law Dictionary
                            </h6>
                            <span class="h2 mb-0">
                                <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Law Dictionary">
                                <span class="text-4xl">{{number_format($dict_count)}}</span> <span class="text-muted">Words</span>
                            </span>
                        </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/rules-of-court')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Legal Maxims
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Legal Maxims">
                                    <span class="text-4xl">{{number_format($maxim_count)}}</span> <span class="text-muted">Maxims</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <a href="{{url('admin/forms-and-precedents')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-3">
                                Resources
                            </h6>
                            <span class="h2 mb-0">
                                <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt="Resources">
                                <span class="text-4xl">{{number_format($resource_count)}}</span> <span class="text-muted">Resources</span>
                            </span>
                        </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <hr>
</div>


<div class="container-fluid">
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <i class="mdi mdi-message mr-2 text-green-0"></i><strong>Welcome back {{Str::words(Auth::user()->name, 1, '')}}</strong> You can now access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="row">
        <div class="col-12 col-xl-4">
            <a href="{{url('admin/judgements')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Legalpedia Resources
                                </h6>
                                <span class="h2 mb-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="">
                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="Legalpedia resources" class="card-img-top">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <span class="text-4xl">{{number_format($all_count)}}</span> <span class="text-muted">Resources</span>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{url('admin/teams')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Legalpedia Teams
                                </h6>
                                <span class="h2 mb-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="">
                                                <i class="fe fe-users text-4xl"></i>
                                                {{-- <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="Legalpedia resources" class="card-img-top"> --}}
                                            </a>
                                        </div>
                                        <div class="col">
                                            <span class="text-4xl"> {{number_format($team_count)}}</span> <span class="text-muted">Teams created</span>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{url('admin/articles')}}" class="link_item">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Legalpedia Articles
                                </h6>
                                <span class="h2 mb-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="">
                                                <i class="fe fe-file text-4xl"></i>
                                                {{-- <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="Legalpedia resources" class="card-img-top"> --}}
                                            </a>
                                        </div>
                                        <div class="col">
                                            <span class="text-4xl"> {{number_format($article_count)}}</span> <span class="text-muted">Articles</span>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        Latest Judgements
                    </h4>
                    <a class="small" href="{{url('admin/judgements')}}">View all</a>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush list-group-activity my-n3">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                        <i class="fe fe-mail"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col ms-n2">
                                    <h5 class="mb-1">
                                        Launchday 1.4.0 update email sent
                                    </h5>
                                    <p class="small text-gray-700 mb-0">
                                        Sent to all 1,851 subscribers over a 24 hour period
                                    </p>
                                    <small class="text-muted">
                                        2m ago
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card">
                <div class="card-header">

                  <!-- Title -->
                  <h4 class="card-header-title">
                    Recent Activity
                  </h4>

                  <!-- Button -->
                  <a class="small" href="#!">View all</a>

                </div>
                <div class="card-body">

                  <!-- List group -->
                  <div class="list-group list-group-flush list-group-activity my-n3">
                    <div class="list-group-item">
                      <div class="row">
                        <div class="col-auto">

                          <!-- Avatar -->
                          <div class="avatar avatar-sm">
                            <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                              <i class="fe fe-mail"></i>
                            </div>
                          </div>

                        </div>
                        <div class="col ms-n2">

                          <!-- Heading -->
                          <h5 class="mb-1">
                            Launchday 1.4.0 update email sent
                          </h5>

                          <!-- Text -->
                          <p class="small text-gray-700 mb-0">
                            Sent to all 1,851 subscribers over a 24 hour period
                          </p>

                          <!-- Time -->
                          <small class="text-muted">
                            2m ago
                          </small>

                        </div>
                      </div> <!-- / .row -->
                    </div>
                    <div class="list-group-item">
                      <div class="row">
                        <div class="col-auto">

                          <!-- Avatar -->
                          <div class="avatar avatar-sm">
                            <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                              <i class="fe fe-archive"></i>
                            </div>
                          </div>

                        </div>
                        <div class="col ms-n2">

                          <!-- Heading -->
                          <h5 class="mb-1">
                            New project "Goodkit" created
                          </h5>

                          <!-- Text -->
                          <p class="small text-gray-700 mb-0">
                            Looks like there might be a new theme soon.
                          </p>

                          <!-- Time -->
                          <small class="text-muted">
                            2h ago
                          </small>

                        </div>
                      </div> <!-- / .row -->
                    </div>
                    <div class="list-group-item">
                      <div class="row">
                        <div class="col-auto">

                          <!-- Avatar -->
                          <div class="avatar avatar-sm">
                            <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                              <i class="fe fe-code"></i>
                            </div>
                          </div>

                        </div>
                        <div class="col ms-n2">

                          <!-- Heading -->
                          <h5 class="mb-1">
                            Dashkit 1.5.0 was deployed.
                          </h5>

                          <!-- Text -->
                          <p class="small text-gray-700 mb-0">
                            A successful to deploy to production was executed.
                          </p>

                          <!-- Time -->
                          <small class="text-muted">
                            2m ago
                          </small>

                        </div>
                      </div> <!-- / .row -->
                    </div>
                    <div class="list-group-item">
                      <div class="row">
                        <div class="col-auto">

                          <!-- Avatar -->
                          <div class="avatar avatar-sm">
                            <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                              <i class="fe fe-git-branch"></i>
                            </div>
                          </div>

                        </div>
                        <div class="col ms-n2">

                          <!-- Heading -->
                          <h5 class="mb-1">
                            "Update Dependencies" branch was created.
                          </h5>

                          <!-- Text -->
                          <p class="small text-gray-700 mb-0">
                            This branch was created off of the "master" branch.
                          </p>

                          <!-- Time -->
                          <small class="text-muted">
                            2m ago
                          </small>

                        </div>
                      </div> <!-- / .row -->
                    </div>
                  </div>

                </div>
              </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="wizardSteps">
                <div class="tab-pane fade show active" id="year" role="tabpanel" aria-labelledby="year-tab">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-lg list-group-flush list my-n4">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="#!" class="avatar text-color avatar-lg">
                                                <i class="fe fe-file"></i>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <h4 class="mb-1 item-name">
                                                <a href="">Some Content</a>
                                            </h4>
                                            <p class="card-text small text-muted">
                                                26th, December 2021
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-lg list-group-flush list my-n4">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="#!" class="avatar text-color avatar-lg">
                                                <i class="fe fe-file"></i>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <h4 class="mb-1 item-name">
                                                <a href="">Some Content</a>
                                            </h4>
                                            <p class="card-text small text-muted">
                                                26th, December 2021
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="legal" role="tabpanel" aria-labelledby="legal-tab">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-lg list-group-flush list my-n4">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="#!" class="avatar text-color avatar-lg">
                                                <i class="fe fe-file"></i>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <h4 class="mb-1 item-name">
                                                <a href="">Some Content</a>
                                            </h4>
                                            <p class="card-text small text-muted">
                                                26th, December 2021
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid mt-6">
    <div class="header-body mb-4 mt-n5 mt-md-n6">
      <div class="row align-items-center">
        <div class="col">
            <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="year-tab" data-toggle="tab" href="#year" role="tab" aria-controls="year" aria-selected="true">
                        LegalPedia Activities
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="subject-tab" data-toggle="tab" href="#subject" role="tab" aria-controls="subject" aria-selected="false">
                        My Activities
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="legal-tab" data-toggle="tab" href="#legal" role="tab" aria-controls="legal" aria-selected="false">
                        Team Activities
                    </a>
                </li>
            </ul>
        </div>
      </div>
    </div>
</div>
