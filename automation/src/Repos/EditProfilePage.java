package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class EditProfilePage extends BasePage{
private static String Url = "EditProfile";
	
	public static void GoToPage(WebDriver driver) {
		BasePage.GoToPageUrl(driver, Url);
	}
	public static WebElement editEmail(WebDriver driver) {
		return driver.findElement(By.id("email"));
	}
	public static WebElement editDepartment(WebDriver driver) {
		return driver.findElement(By.id("departmentName"));
	}	
	public static WebElement editFirstName(WebDriver driver) {
		return driver.findElement(By.id("firstname"));
	}	
	public static WebElement editLastName(WebDriver driver) {
		return driver.findElement(By.id("lastname"));
	}
	public static WebElement editContactNo(WebDriver driver) {
		return driver.findElement(By.id("contactno"));
	}	
	public static WebElement oldPassword(WebDriver driver) {
		return driver.findElement(By.id("password_old"));
	}
	public static WebElement newPassword(WebDriver driver) {
		return driver.findElement(By.id("password_new"));
	}
	public static WebElement confirmNewPassword(WebDriver driver) {
		return driver.findElement(By.id("password_new_confirm"));
	}
	public static WebElement FNameAlert(WebDriver driver) {
		return driver.findElement(By.id("empty_firstname"));
	}
	public static WebElement LNameAlert(WebDriver driver) {
		return driver.findElement(By.id("empty_firstname"));
	}
	public static WebElement contactAlert(WebDriver driver) {
		return driver.findElement(By.id("invalid_contact"));
	}
	public static WebElement passwordshortAlert(WebDriver driver) {
		return driver.findElement(By.id("password_short"));
	}
	public static WebElement newConfirmAlert(WebDriver driver) {
		return driver.findElement(By.id("new_and_confirm_mismatch"));
	}
	public static WebElement newEmptyAlert(WebDriver driver) {
		return driver.findElement(By.id("new_password_empty"));
	}
	public static WebElement OldCurrentAlert(WebDriver driver) {
		return driver.findElement(By.id("old_current_mismatch"));
	}
	
	public static WebElement Submit(WebDriver driver) {
		return driver.findElement(By.xpath("//button[@type='submit']"));
	}
	
	public static WebElement BackToDash(WebDriver driver) {
		return driver.findElement(By.partialLinkText("Back to Dashboard"));
	}
	
	public static String[] getDetails(WebDriver driver)
	{
		String beforeEditDetails[] = new String[8];
		String email = EditProfilePage.editEmail(driver).getAttribute("value");
		beforeEditDetails[0] = email;
		String firstName = EditProfilePage.editFirstName(driver).getAttribute("value");
		beforeEditDetails[1] = firstName;
		String lastName = EditProfilePage.editLastName(driver).getAttribute("value");
		beforeEditDetails[2] = lastName;
		String contactNo = EditProfilePage.editContactNo(driver).getAttribute("value");
		beforeEditDetails[3] = contactNo;
		String department = EditProfilePage.editDepartment(driver).getAttribute("value");
		beforeEditDetails[4] = department;
		String oldpass = EditProfilePage.oldPassword(driver).getAttribute("value");
		beforeEditDetails[5] = oldpass;
		String newpass = EditProfilePage.newPassword(driver).getAttribute("value");
		beforeEditDetails[6] = newpass;
		String confirmpass = EditProfilePage.confirmNewPassword(driver).getAttribute("value");
		beforeEditDetails[7] = confirmpass;
		return (beforeEditDetails);
		
	}
	
	//change contact no error
	public static WebElement contactError(WebDriver driver) {
		return driver.findElement(By.partialLinkText(""));
	}
	
	//change password error
	public static WebElement passwordError(WebDriver driver) {
		return driver.findElement(By.partialLinkText(""));
	}
	public static WebElement NewPasswordAlert(WebDriver driver) {
		return driver.findElement(By.id("new_password_empty"));
	}
	public static WebElement successAlert(WebDriver driver) {
		return driver.findElement(By.id("success"));
	}
	
	
	/*public void editDetails(WebDriver driver)
	{
		EditProfilePage.editFirstName(driver).sendKeys("");
		EditProfilePage.editLastName(driver).sendKeys("");
		EditProfilePage.editContactNo(driver).sendKeys("");
		EditProfilePage.editDepartment(driver).sendKeys("");
		EditProfilePage.Submit(driver).click();
	}*/
}
