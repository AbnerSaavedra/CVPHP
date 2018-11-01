<?php 
namespace App\Controller;

use App\Models\Job;
use Respect\Validation\Validator;

class JobController extends BaseController{
	public function getAddJobAction($request){
		$responseMessage = null;
		if ($request->getMethod() == 'POST') {
			$postData = $request->getParsedBody();
			$jobValidator = Validator::key('title', Validator::stringType()->notEmpty())
											->key('description', Validator::stringType()->notEmpty());
			try {

				$jobValidator->assert($postData);
				$postData = $request->getParsedBody();
				$files = $request->getUploadedFiles();
				$logo = $files['logo'];

				if ($logo->getError() == UPLOAD_ERR_OK){
					$fileName = $logo->getClientFilename();
					$logo->moveTo("uploads/$fileName");
				}
				
				$job = new Job();
				$job->title = $postData['title'];
				$job->description = $postData['description'];
				$job->logo = "uploads/$fileName";
				$job->save();

				$responseMessage = "Saved";
				
			} catch (\Exception $e) {
				
				$responseMessage = $e->getMessage();
			}

		}
		
		return $this->renderHTML('addJob.twig', ['responseMessage' => $responseMessage]);
	}
}