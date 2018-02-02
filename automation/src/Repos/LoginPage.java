package Repos;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;


public class LoginPage extends BasePage {

	private static String Url = "";
	
	public static void GoToPage(WebDriver driver) {
		BasePage.GoToPageUrl(driver, Url);
	}
	
	public static WebElement UserName(WebDriver driver) {
		return driver.findElement(By.id("email"));
	}
		
	public static WebElement Password(WebDriver driver) {
		return driver.findElement(By.id("password"));
	}
	public static WebElement ForgotPasssword(WebDriver driver) {
		return driver.findElement(By.partialLinkText("Forgot Your Password?"));
	}
	
	public static WebElement Submit(WebDriver driver) {
		return driver.findElement(By.cssSelector("button[type='submit']"));
	}
	public static WebElement passwordAlert(WebDriver driver) {
		return driver.findElement(By.id("passwordAlert"));
	}
	public static WebElement emailAlert(WebDriver driver) {
		return driver.findElement(By.id("emailAlert"));
	}
	public static WebElement Alert(WebDriver driver) {
	
		return driver.findElement(By.className("help-block"));
	}
	
	public static void LoginAsStudent(WebDriver driver) throws Exception {
		LoginPage.UserName(driver).sendKeys("achouhan@unomaha.edu");
		LoginPage.Password(driver).sendKeys("111111");
		Thread.sleep(2000);
		LoginPage.Submit(driver).click();
		Thread.sleep(2000);
	}
	
	public static void LoginAsAdmin(WebDriver driver) {
		LoginPage.UserName(driver).sendKeys("");
		LoginPage.Password(driver).sendKeys("");
		LoginPage.Submit(driver).click();
	}
	
	public static void LoginAsInstructor(WebDriver driver) {
		LoginPage.UserName(driver).sendKeys("");
		LoginPage.Password(driver).sendKeys("");
		LoginPage.Submit(driver).click();
	}
	
}
