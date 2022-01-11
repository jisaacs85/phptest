pipeline {

  agent any

  options {
    timestamps()
  }

  stages {
    stage('PHPUnit Test') {
      steps {
        echo 'Running PHPUnit...'
        sh '/bin/phpunit ${WORKSPACE}'
      }
    }
    stage('SonarQube analysis') {
      steps {
        withSonarQubeEnv('Jenkins Sonarqube') {
          sh 'echo "sonar.projectKey=production:php-project" > ${WORKSPACE}/sonar-project.properties'
          sh 'echo "sonar.sources=." >> ${WORKSPACE}/sonar-project.properties'
          sh '/opt/sonarqube-scanner/bin/sonar-scanner'
        }
      }
    }
    stage('JIRA') {
      when {
        not {
          branch 'master'
        }
      }
      steps {
        script {
          echo 'jiraGetIssue 1'
          def issue = jiraGetIssue idOrKey: env.GIT_BRANCH, site: 'jenkins-jira'
          echo 'jiraGetIssue 1'
          if (issue.code.toString() == '200') {
            echo 'jiraGetIssue 3'
            response = jiraAddComment site: 'jenkins-jira', idOrKey: env.GIT_BRANCH, comment: "Build result: Job- ${JOB_NAME} Build Number - ${BUILD_NUMBER} Build URL - ${BUILD_URL}"
            echo 'jiraGetIssue 4'
          }
          else {
            echo 'Create JIRA 1'
            def issueInfo = 
            [
              fields: [
                project: [
                  key: "KAN"
                ],
                summary: "Review build ${GIT_BRANCH}",
                description: "Review changes for build ${GIT_BRANCH}",
                issueType: [
                  name: "Task"
                ]
              ]
            ]
            echo 'Create JIRA 2'
            response = jiraNewIssue site: 'jenkins-jira', issue: issueInfo
            echo 'Create JIRA 3'
          }
        }
      }
    }
    stage('Merge PR') {
      when {
        branch 'PR-*'
      }
      steps {
        sh 'git remote set-url origin git@github.com:jisaacs85/phptest.git'
        sh 'git remote set-branches --add origin ${CHANGE_TARGET}'
        sh 'git fetch origin'
        sh 'git checkout ${CHANGE_TARGET}'
        sh 'git merge --no-ff ${GIT_COMMIT}'
        sh 'git push origin ${CHANGE_TARGET}'
      }
    }
  }
}

