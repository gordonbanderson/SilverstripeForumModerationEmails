<?php
class ForumEmailPostDecorator extends DataObjectDecorator {
	function onAfterWrite() {
		global $forum_moderator_email_address;
		
		//The variable $forum_moderator_email_address must be set in the mysite/_config.php in order for email to be sent
		// Otherwise it is ignored and forms are posted without moderators being emailed
		if (isset($forum_moderator_email_address)) {
			error_log("LOG MESSAGE FROM FORUM EMAIL POST DECORATOR LINK IS ".$this->owner->AbsoluteLink());
			$email = new Email();
			$email->setFrom(Email::getAdminEmail());
			$email->setTo($forum_moderator_email_address);
			$email->setFrom($forum_moderator_email_address);
			$email->setSubject('Moderation: New Forum Posting - ' . $this->owner->Title);
			$email->setTemplate('Forum_ModeratorNotification');
			$email->populateTemplate(array(
				'AbsoluteLink' => $this->owner->AbsoluteLink(),
				'Content' => $this->owner->Content
			));
			$email->send();
		}
		parent::onAfterWrite();
	}
}
