package Tests;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.Test;

import Repos.LoginPage;
import Repos.layoutPage;

public class testingid {
  @Test
  public void f() throws Exception {
	  WebDriver driver = new FirefoxDriver();
	  
	  LoginPage.GoToPage(driver);
	  LoginPage.LoginAsStudent(driver);
	  layoutPage.dropdown(driver).click();
	  layoutPage.logout(driver).click();
	  
	  
	  
  }
}
